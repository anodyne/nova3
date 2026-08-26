<?php

declare(strict_types=1);

namespace Nova\Foundation\Providers;

use Anodyne\TablerIcons\Tabler;
use Carbon\CarbonImmutable;
use Filament\Actions\Action;
use Filament\Forms\View\FormsIconAlias;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Notifications\View\NotificationsIconAlias;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\Size;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\View\SupportIconAlias;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\View\TablesIconAlias;
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
use InvalidArgumentException;
use Livewire\Livewire;
use Nova\Addons\Models\Addon;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Forms\Models\Form;
use Nova\Foundation\Application;
use Nova\Foundation\Console\Commands\InstallDataMigrations;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Foundation\Environment\Environment;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Icons\NotificationIcon;
use Nova\Foundation\Listeners\AuthenticationEventSubscriber;
use Nova\Foundation\Listeners\SetEmailSubjectPrefix;
use Nova\Foundation\Livewire\ConfirmationModal;
use Nova\Foundation\Livewire\IconPicker;
use Nova\Foundation\Livewire\Rating;
use Nova\Foundation\Macros\ArrMacros;
use Nova\Foundation\Macros\CreateUpdateOrDelete;
use Nova\Foundation\Macros\DateMacros;
use Nova\Foundation\Macros\NotificationMacros;
use Nova\Foundation\Macros\StrMacros;
use Nova\Foundation\Macros\TextColumnMacros;
use Nova\Foundation\Models\Activity;
use Nova\Foundation\Nova;
use Nova\Foundation\NovaBladeDirectives;
use Nova\Foundation\NovaManager;
use Nova\Foundation\Responses\FiltersManager;
use Nova\Foundation\Values\DatabaseVersionInfo;
use Nova\Foundation\View\Compilers\BladeCompiler;
use Nova\Foundation\View\Components\Tips;
use Nova\Foundation\View\Layouts\AdminLayout;
use Nova\Foundation\View\Layouts\AuthLayout;
use Nova\Foundation\View\Layouts\EmailLayout;
use Nova\Foundation\View\Layouts\PublicLayout;
use Nova\Menus\Models\MenuItem;
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

/** @property Application $app */
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configureNovaSingleton();
        $this->configureDatabaseRepositories();
        $this->configureDataMigrationCommands();

        $this->app->extend('blade.compiler', fn ($compiler, Application $app) => tap(new BladeCompiler(
            $app['files'],
            $app['config']['view.compiled'],
            $app['config']->get('view.relative_hash', false) ? $app->basePath() : '',
            $app['config']->get('view.cache', true),
            $app['config']->get('view.compiled_extension', 'php'),
        ), function ($blade): void {
            $blade->component('dynamic-component', DynamicComponent::class);
        }));
    }

    public function boot(): void
    {
        Model::shouldBeStrict(! app()->environment('production'));

        Date::use(CarbonImmutable::class);

        RedirectIfAuthenticated::redirectUsing(fn (): string => route('admin.dashboard'));

        // Make sure the file finder can find Javascript files
        $this->app['view']->addExtension('js', 'file');

        $this->app->scoped('nova.environment', fn (): Environment => Environment::make());

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
        $this->configureBlade();

        if (Nova::isInstalled()) {
            $this->configureLivewireComponents();
            $this->configureResponseFilters();
            $this->configureFilament();
            $this->configureGlobalEventListeners();
            $this->configureAddonProviders();
        }
    }

    protected function configureNovaSingleton(): void
    {
        $this->app->scoped('nova', NovaManager::class);
    }

    protected function configureMacros(): void
    {
        Arr::mixin(new ArrMacros);
        Date::mixin(new DateMacros);
        Redirector::mixin(new NotificationMacros);
        RedirectResponse::mixin(new NotificationMacros);
        Str::mixin(new StrMacros);
        TextColumn::mixin(new TextColumnMacros);

        Route::macro('findPageFromRoute', function () {
            /** @var Route $route */
            $route = $this;

            return once(fn () => Page::key($route->getName())->first());
        });

        ComponentAttributeBag::macro('hasStartsWith', function ($key): bool {
            /** @var ComponentAttributeBag $bag */
            $bag = $this;

            return (bool) $bag->whereStartsWith($key)->first();
        });

        HasMany::macro('createUpdateOrDelete', function (iterable $records): void {
            /** @var HasMany<Model, Model> $hasMany */
            $hasMany = $this;

            (new CreateUpdateOrDelete($hasMany, $records))();
        });

        Blueprint::macro('prefixedId', function (string $name = 'prefixed_id') {
            /** @var Blueprint $table */
            $table = $this;

            return $table->string($name)->nullable()->unique();
        });

        DB::macro('versionInfo', function (): DatabaseVersionInfo {
            $pdo = DB::getPdo();
            $driver = DB::getDriverName();

            return DatabaseVersionInfo::fromPdo($pdo, $driver);
        });
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

        Blade::directive('icon', NovaBladeDirectives::icon(...));
        Blade::directive('novaAdminScripts', NovaBladeDirectives::novaAdminScripts(...));
        Blade::directive('novaAdminStyles', NovaBladeDirectives::novaAdminStyles(...));
        Blade::directive('novaPublicScripts', NovaBladeDirectives::novaPublicScripts(...));
        Blade::directive('novaPublicStyles', NovaBladeDirectives::novaPublicStyles(...));
        Blade::directive('novaSetupScripts', NovaBladeDirectives::novaSetupScripts(...));

        Blade::directive('mysql', fn ($expression): string => '<?php if(app("nova.environment")->database->isMysql()): ?>');

        Blade::directive('endmysql', fn ($expression): string => '<?php endif; ?>');
    }

    protected function configureLivewireComponents(): void
    {
        Livewire::addComponent(name: 'rating', class: Rating::class);
        Livewire::addComponent(name: 'icon-picker', class: IconPicker::class);
        Livewire::addComponent(name: 'confirmation-modal', class: ConfirmationModal::class);
    }

    protected function configureResponseFilters(): void
    {
        $this->app->singleton(
            'nova.response-filters',
            fn (): FiltersManager => new FiltersManager
        );
    }

    protected function configureDatabaseFactories(): void
    {
        Factory::guessFactoryNamesUsing(
            function (string $model): string {
                $factory = 'Database\\Factories\\'.Str::afterLast($model, '\\').'Factory';

                if (! is_subclass_of($factory, Factory::class)) {
                    throw new InvalidArgumentException("Factory [{$factory}] does not exist.");
                }

                return $factory;
            }
        );
    }

    protected function configureFilament(): void
    {
        FilamentColor::register($this->app['nova.settings']?->appearance?->getColors() ?? []);

        FilamentIcon::register([
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_DELETE => Tabler::Trash,
            FormsIconAlias::COMPONENTS_BUILDER_ACTIONS_REORDER => Tabler::ArrowsSort,
            FormsIconAlias::COMPONENTS_KEY_VALUE_ACTIONS_DELETE => Tabler::Trash,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_DELETE => Tabler::Trash,
            FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_REORDER => Tabler::ArrowsSort,

            TablesIconAlias::ACTIONS_COLUMN_MANAGER => Tabler::Columns3,
            TablesIconAlias::ACTIONS_DISABLE_REORDERING => Tabler::Check,
            TablesIconAlias::ACTIONS_ENABLE_REORDERING => Tabler::ArrowsSort,
            TablesIconAlias::ACTIONS_FILTER => Tabler::Filter,
            TablesIconAlias::ACTIONS_GROUP => Tabler::BoxMultiple,
            TablesIconAlias::ACTIONS_OPEN_BULK_ACTIONS => Tabler::DotsVertical,
            TablesIconAlias::REORDER_HANDLE => Tabler::GripVertical,
            TablesIconAlias::SEARCH_FIELD => Tabler::Search,

            NotificationsIconAlias::NOTIFICATION_DANGER => NotificationIcon::XCircle,
            NotificationsIconAlias::NOTIFICATION_INFO => NotificationIcon::InfoCircle,
            NotificationsIconAlias::NOTIFICATION_SUCCESS => NotificationIcon::CheckCircle,
            NotificationsIconAlias::NOTIFICATION_WARNING => NotificationIcon::AlertTriangle,

            SupportIconAlias::MODAL_CLOSE_BUTTON => Tabler::X,
            SupportIconAlias::PAGINATION_PREVIOUS_BUTTON => Tabler::ChevronLeft,
            SupportIconAlias::PAGINATION_NEXT_BUTTON => Tabler::ChevronRight,
        ]);

        Table::configureUsing(function (Table $table): void {
            $table
                ->filtersTriggerAction(fn (Action $action): Action => $action->size(Size::Large)->color('gray'))
                ->columnManagerTriggerAction(fn (Action $action): Action => $action->size(Size::Large)->color('gray'))
                ->reorderRecordsTriggerAction(fn (Action $action, bool $isReordering): Action => $action
                    ->size(Size::Large)
                    ->color($isReordering ? 'primary' : 'gray'));
        });

        Timeline::configureUsing(function (Timeline $timeline): void {
            $timeline
                ->attributeLabels([
                    'order_column' => 'sort order',
                ])
                ->attributeValues([
                    'status' => fn (?BasicStatus $value): string => strtolower($value->value ?? ''),
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
                ->itemDateTimeTimezone(fn (): string => Auth::user()->preferences->timezone ?? 'UTC')
                ->itemIcons([
                    'created' => Tabler::Plus->value,
                    'duplicated' => Tabler::Copy->value,
                ])
                ->itemIconColors([
                    'created' => 'success',
                    'duplicated' => 'success',
                ])
                ->modifyEventDescriptionUsing(function (string $eventDescription, Activity $activity, string $recordTitle, ?string $causerName, ?string $changesSummary): string {
                    if ($activity->log_name === 'impersonation') {
                        $impersonatorId = $activity->getProperty('impersonated_by');

                        return __('activity.impersonated', [
                            'user' => is_int($impersonatorId) || is_string($impersonatorId)
                                ? User::find($impersonatorId)?->name
                                : null,
                            'description' => $eventDescription,
                        ]);
                    }

                    return $eventDescription;
                });
        });

        TimelineAction::configureUsing(function (TimelineAction $action): void {
            $action
                ->icon(Tabler::History)
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
                'Extensions' => collect(Arr::wrap(data_get(Cache::get(CacheKeys::Addons->value), 'extension', [])))->join(', '),
                'Genre' => collect(Arr::wrap(data_get(Cache::get(CacheKeys::Addons->value), 'genre', [])))->join(', '),
                'Rank set' => collect(Arr::wrap(data_get(Cache::get(CacheKeys::Addons->value), 'rank', [])))->join(', '),
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
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));

        RateLimiter::for('join', fn (Request $request) => Limit::perMinute(15)->by($request->ip()));

        RateLimiter::for('contact', fn (Request $request) => Limit::perMinute(15)->by($request->ip()));
    }

    protected function configureAddonProviders(): void
    {
        collect(Arr::wrap(data_get(Cache::get(CacheKeys::Addons->value), 'extension', [])))
            ->filter(fn (mixed $addon): bool => is_string($addon))
            ->map(fn (string $addon): string => "Addons\\{$addon}\\Providers\\AddonServiceProvider")
            ->filter(fn (string $provider): bool => is_subclass_of($provider, ServiceProvider::class))
            ->each(function (string $provider): void {
                $serviceProvider = new $provider($this->app);

                if (method_exists($serviceProvider, 'boot')) {
                    $serviceProvider->boot();
                }
            });
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

    /**
     * Swap in a data migration install command that keeps its own name so it
     * stops shadowing Laravel's `migrate:install`.
     *
     * @see InstallDataMigrations
     */
    protected function configureDataMigrationCommands(): void
    {
        $this->app->singleton(
            'command.migrate-data.install',
            fn (Application $app): InstallDataMigrations => new InstallDataMigrations($app['migration.data.repository'])
        );
    }
}
