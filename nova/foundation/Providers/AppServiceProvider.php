<?php

declare(strict_types=1);

namespace Nova\Foundation\Providers;

use Carbon\CarbonImmutable;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\DynamicComponent;
use Illuminate\View\Factory as ViewFactory;
use Livewire\Livewire;
use Nova\Addons\Models\Addon;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Forms\Models\Form;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Environment\Environment;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Icons\IconSets;
use Nova\Foundation\Icons\TablerIconSet;
use Nova\Foundation\Listeners\AuthenticationEventSubscriber;
use Nova\Foundation\Listeners\SetEmailSubjectPrefix;
use Nova\Foundation\Livewire\AdvancedColorPicker;
use Nova\Foundation\Livewire\ColorShadePicker;
use Nova\Foundation\Livewire\ConfirmationModal;
use Nova\Foundation\Livewire\Editor;
use Nova\Foundation\Livewire\IconPicker;
use Nova\Foundation\Livewire\Rating;
use Nova\Foundation\Macros\ArrMacros;
use Nova\Foundation\Macros\CreateUpdateOrDelete;
use Nova\Foundation\Macros\NotificationMacros;
use Nova\Foundation\Macros\StrMacros;
use Nova\Foundation\Macros\TextColumnMacros;
use Nova\Foundation\Macros\ViewMacros;
use Nova\Foundation\Nova;
use Nova\Foundation\NovaBladeDirectives;
use Nova\Foundation\NovaManager;
use Nova\Foundation\Responses\FiltersManager;
use Nova\Foundation\View\Compilers\BladeCompiler;
use Nova\Foundation\View\Components\Tips;
use Nova\Foundation\View\Layouts\AdminLayout;
use Nova\Foundation\View\Layouts\AuthLayout;
use Nova\Foundation\View\Layouts\EmailLayout;
use Nova\Foundation\View\Layouts\PublicLayout;
use Nova\Menus\Models\MenuItem;
use Nova\Navigation\Models\Navigation;
use Nova\Pages\Models\Page;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Reporting\Repositories\MySQLReportingRepository;
use Nova\Reporting\Repositories\PostgresReportingRepository;
use Nova\Reporting\Repositories\ReportingRepositoryInterface;
use Nova\Settings\Models\Settings;
use Nova\Stories\Models\PostType;
use Nova\Themes\Models\Theme;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configureNovaSingleton();
        $this->configureDatabaseRepositories();

        $this->app->extend('blade.compiler', function ($compiler, $app) {
            return tap(new BladeCompiler(
                $app['files'],
                $app['config']['view.compiled'],
                $app['config']->get('view.relative_hash', false) ? $app->basePath() : '',
                $app['config']->get('view.cache', true),
                $app['config']->get('view.compiled_extension', 'php'),
            ), function ($blade) {
                $blade->component('dynamic-component', DynamicComponent::class);
            });
        });
    }

    public function boot(): void
    {
        Model::shouldBeStrict(! app()->environment('production'));

        Date::use(CarbonImmutable::class);

        RedirectIfAuthenticated::redirectUsing(fn () => route('admin.dashboard'));

        // Make sure the file finder can find Javascript files
        $this->app['view']->addExtension('js', 'file');

        $this->app->scoped('nova.environment', function () {
            $environment = Environment::make();

            return $environment;
        });

        $this->app->scoped('nova.settings', function () {
            if (Nova::isInstalled()) {
                return once(fn () => Settings::custom()->first());
            }

            return null;
        });

        $this->configureRateLimiting();
        $this->configureMacros();
        $this->configureAboutCommand();
        $this->configureDatabaseFactories();
        $this->configureIconManager();
        $this->configureBlade();

        if (Nova::isInstalled()) {
            // cache()->rememberForever(
            //     'nova.nav.admin',
            //     fn () => Navigation::with('children.page', 'page', 'authorization')->admin()->topLevel()->get()
            // );

            // cache()->rememberForever(
            //     'nova.nav.public',
            //     fn () => Navigation::with('children.page', 'page', 'authorization')->public()->topLevel()->get()
            // );

            $this->configureLivewireComponents();
            $this->configureResponseFilters();
            $this->configureFilament();
            $this->configureGlobalEventListeners();
            $this->configureAddonProviders();
        }
    }

    protected function configureNovaSingleton()
    {
        $this->app->scoped('nova', NovaManager::class);
    }

    protected function configureMacros()
    {
        Arr::mixin(new ArrMacros);
        Redirector::mixin(new NotificationMacros);
        RedirectResponse::mixin(new NotificationMacros);
        Str::mixin(new StrMacros);
        TextColumn::mixin(new TextColumnMacros);
        ViewFactory::mixin(new ViewMacros);

        Route::macro('findPageFromRoute', function () {
            /** @var Route */
            $route = $this;

            return once(fn () => Page::key($route->getName())->first());
        });

        ComponentAttributeBag::macro('hasStartsWith', function ($key) {
            /** @var ComponentAttributeBag */
            $bag = $this;

            return (bool) $bag->whereStartsWith($key)->first();
        });

        HasMany::macro('createUpdateOrDelete', function (iterable $records) {
            /** @var HasMany */
            $hasMany = $this;

            return (new CreateUpdateOrDelete($hasMany, $records))();
        });

        Blueprint::macro('prefixedId', function (string $name = 'prefixed_id') {
            /** @var Blueprint */
            $table = $this;

            return $table->string($name)->nullable()->unique();
        });

        DB::macro('versionInfo', function (): object {
            $pdo = DB::getPdo();
            $driver = DB::getDriverName();

            $rawVersion = $pdo->query('SELECT VERSION()')->fetchColumn();

            return (object) [
                'driver' => $driver,
                'version' => $rawVersion,
                'isMaria' => $driver === 'mysql' && str_contains($rawVersion, 'MariaDB'),
                'isMysql' => $driver === 'mysql' && ! str_contains($rawVersion, 'MariaDB'),
                'isPostgres' => $driver === 'pgsql',
            ];
        });
    }

    protected function configureIconManager()
    {
        $iconSets = new IconSets;
        $iconSets->addDefault('tabler', new TablerIconSet);

        $this->app->scoped(IconSets::class, fn () => $iconSets);
    }

    protected function configureBlade(): void
    {
        Blade::anonymousComponentPath(resource_path('views/public-components'), 'public');
        Blade::anonymousComponentPath(resource_path('views/setup-components'), 'setup');

        Blade::component('admin-layout', AdminLayout::class);
        Blade::component('auth-layout', AuthLayout::class);
        Blade::component('email-layout', EmailLayout::class);
        Blade::component('public-layout', PublicLayout::class);

        Blade::component('tips', Tips::class);

        Blade::directive('icon', [NovaBladeDirectives::class, 'icon']);
        Blade::directive('novaAdminScripts', [NovaBladeDirectives::class, 'novaAdminScripts']);
        Blade::directive('novaAdminStyles', [NovaBladeDirectives::class, 'novaAdminStyles']);
        Blade::directive('novaPublicScripts', [NovaBladeDirectives::class, 'novaPublicScripts']);
        Blade::directive('novaPublicStyles', [NovaBladeDirectives::class, 'novaPublicStyles']);
        Blade::directive('novaSetupScripts', [NovaBladeDirectives::class, 'novaSetupScripts']);

        Blade::directive('mysql', function ($expression) {
            return '<?php if(app("nova.environment")->database->isMysql()): ?>';
        });

        Blade::directive('endmysql', function ($expression) {
            return '<?php endif; ?>';
        });
    }

    protected function configureLivewireComponents()
    {
        // Livewire::component('nova:editor', Editor::class);
        Livewire::component('rating', Rating::class);
        Livewire::component('icon-picker', IconPicker::class);
        Livewire::component('color-shade-picker', ColorShadePicker::class);
        Livewire::component('advanced-color-picker', AdvancedColorPicker::class);
        // Livewire::component('confirmation-modal', ConfirmationModal::class);
    }

    protected function configureResponseFilters(): void
    {
        $this->app->singleton(
            'nova.response-filters',
            fn () => new FiltersManager
        );
    }

    protected function configureDatabaseFactories()
    {
        Factory::guessFactoryNamesUsing(
            fn ($model) => 'Database\\Factories\\'.Str::afterLast($model, '\\').'Factory'
        );
    }

    protected function configureFilament(): void
    {
        FilamentColor::register($this->app['nova.settings']?->appearance?->getColors() ?? []);

        FilamentColor::addShades('badge', [200, 300, 400, 700, 800, 950]);
        FilamentColor::addShades('tables::columns.toggle-column.on', [500, 900]);
        FilamentColor::addShades('forms::components.toggle.on', [500, 900]);

        FilamentIcon::register([
            'forms::components.builder.actions.delete' => iconName('trash'),
            'forms::components.builder.actions.reorder' => iconName('arrows-sort'),
            'forms::components.key-value.actions.delete' => iconName('trash'),
            'forms::components.repeater.actions.delete' => iconName('trash'),
            'forms::components.repeater.actions.reorder' => iconName('arrows-sort'),
            'tables::actions.disable-reordering' => iconName('check'),
            'tables::actions.enable-reordering' => iconName('arrows-sort'),
            'tables::actions.filter' => iconName('filter'),
            'tables::actions.group' => iconName('group'),
            'tables::actions.toggle-columns' => iconName('columns'),
            'tables::reorder.handle' => iconName('drag-handle'),
            'tables::search-field' => iconName('search'),
            'modal.close-button' => iconName('x'),
            'notifications::notification.danger' => 'notis-danger',
            'notifications::notification.info' => 'notis-info',
            'notifications::notification.success' => 'notis-success',
            'notifications::notification.warning' => 'notis-warning',
            'pagination.previous-button' => iconName('chevron-left'),
            'pagination.next-button' => iconName('chevron-right'),
        ]);

        Table::configureUsing(function (Table $table) {
            $table
                ->filtersTriggerAction(function ($action) {
                    return $action->size('lg')->color('gray');
                })
                ->toggleColumnsTriggerAction(function ($action) {
                    return $action->size('lg')->color('gray');
                })
                ->reorderRecordsTriggerAction(function ($action, bool $isReordering) {
                    return $action
                        ->size('lg')
                        ->color($isReordering ? 'primary' : 'gray');
                });
        });

        Timeline::configureUsing(function (Timeline $timeline) {
            $timeline
                ->attributeLabels([
                    'order_column' => 'sort order',
                ])
                ->attributeValues([
                    'status' => fn (?BasicStatus $value) => strtolower($value?->value ?? ''),
                ], [
                    Addon::class,
                    Department::class,
                    Form::class,
                    MenuItem::class,
                    Page::class,
                    Position::class,
                    PostType::class,
                    RankGroup::class,
                    RankItem::class,
                    RankName::class,
                    Theme::class,
                ])
                ->causerName(null, 'System')
                ->itemDateTimeTimezone(fn () => Auth::user()?->preferences?->timezone ?? 'UTC')
                ->itemIcons([
                    'created' => iconName('add'),
                    'duplicated' => iconName('copy'),
                ])
                ->itemIconColors([
                    'created' => 'success',
                    'duplicated' => 'success',
                ])
                ->modifyEventDescriptionUsing(function (string $eventDescription, Activity $activity, string $recordTitle, ?string $causerName, ?string $changesSummary) {
                    if ($activity->log_name === 'impersonation') {
                        return __('activity.impersonated', [
                            'user' => User::find($activity->getExtraProperty('impersonated_by'))?->name,
                            'description' => $eventDescription,
                        ]);
                    }

                    return $eventDescription;
                });
        });

        TimelineAction::configureUsing(function (TimelineAction $action) {
            $action
                ->icon(iconName('history'))
                ->label('Activity history');
        }, isImportant: true);

        $this->app->bind(FilamentNotification::class, Notification::class);

        Notifications::alignment(Alignment::Right);
        Notifications::verticalAlignment(VerticalAlignment::End);
    }

    protected function configureAboutCommand(): void
    {
        if (class_exists(AboutCommand::class)) {
            AboutCommand::add('Nova', [
                'Version' => 'v'.Nova::filesVersion(),
                'Extensions' => collect(data_get(cache('nova.addons'), 'extension', []))->join(', '),
                'Genre' => collect(data_get(cache('nova.addons'), 'genre', []))->join(', '),
                'Rank set' => collect(data_get(cache('nova.addons'), 'rank', []))->join(', '),
            ]);
        }
    }

    protected function configureGlobalEventListeners(): void
    {
        Event::listen(Registered::class, SendEmailVerificationNotification::class);
        Event::listen(MessageSending::class, SetEmailSubjectPrefix::class);

        Event::subscribe(AuthenticationEventSubscriber::class);
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('join', function (Request $request) {
            return Limit::perMinute(15)->by($request->ip());
        });

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(15)->by($request->ip());
        });
    }

    protected function configureAddonProviders(): void
    {
        collect(data_get(Cache::get('nova.addons'), 'extension', []))
            ->reject(fn ($addon) => ! file_exists(addon_path($addon.'/Providers/AddonServiceProvider.php')))
            ->flatMap(fn ($addon) => ["Addons\\$addon\\Providers\\AddonServiceProvider"])
            ->each(fn ($addon) => (new $addon($this->app))->boot());
    }

    protected function configureDatabaseRepositories(): void
    {
        $dbDriver = config('database.default');

        if ($dbDriver === 'pgsql') {
            $this->app->bind(ReportingRepositoryInterface::class, PostgresReportingRepository::class);
        } else {
            $this->app->bind(ReportingRepositoryInterface::class, MySQLReportingRepository::class);
        }
    }
}
