<?php

declare(strict_types=1);

namespace Nova\Foundation\Providers;

use Awcodes\Scribble\Facades\ScribbleFacade;
use Carbon\CarbonImmutable;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\DynamicComponent;
use Illuminate\View\Factory as ViewFactory;
use Livewire\Livewire;
use Nova\Forms\Fields;
use Nova\Foundation\Blocks\BlockManager;
use Nova\Foundation\Environment\Environment;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Icons\IconSets;
use Nova\Foundation\Icons\TablerIconSet;
use Nova\Foundation\Listeners\SetEmailSubjectPrefix;
use Nova\Foundation\Livewire\AdvancedColorPicker;
use Nova\Foundation\Livewire\ColorShadePicker;
use Nova\Foundation\Livewire\ConfirmationModal;
use Nova\Foundation\Livewire\Editor;
use Nova\Foundation\Livewire\IconPicker;
use Nova\Foundation\Livewire\Rating;
use Nova\Foundation\Macros;
use Nova\Foundation\Macros\CreateUpdateOrDelete;
use Nova\Foundation\Nova;
use Nova\Foundation\NovaBladeDirectives;
use Nova\Foundation\NovaManager;
use Nova\Foundation\Responses\FiltersManager;
use Nova\Foundation\View\Compilers\BladeCompiler;
use Nova\Foundation\View\Components\EmailLayout;
use Nova\Foundation\View\Components\Tips;
use Nova\Navigation\Models\Navigation;
use Nova\Pages\Blocks;
use Nova\Pages\Models\Page;
use Nova\Settings\Models\Settings;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerNovaSingleton();
        $this->registerResponseFilters();
        // $this->registerFilamentBindings();
        $this->registerBlocks();

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
        $this->registerMacros();
        $this->updateAboutCommand();
        $this->setupFactories();
        $this->registerIcons();
        $this->setupBlade();

        if (Nova::isInstalled()) {
            // cache()->rememberForever(
            //     'nova.nav.admin',
            //     fn () => Navigation::with('children.page', 'page', 'authorization')->admin()->topLevel()->get()
            // );

            // cache()->rememberForever(
            //     'nova.nav.public',
            //     fn () => Navigation::with('children.page', 'page', 'authorization')->public()->topLevel()->get()
            // );

            $this->registerLivewireComponents();
            $this->registerResponseFilters();
            $this->setupFilament();
            $this->setupGlobalEventListeners();
        }
    }

    protected function registerNovaSingleton()
    {
        $this->app->scoped('nova', NovaManager::class);
    }

    protected function registerMacros()
    {
        Arr::mixin(new Macros\ArrMacros());
        Redirector::mixin(new Macros\NotificationMacros());
        RedirectResponse::mixin(new Macros\NotificationMacros());
        Str::mixin(new Macros\StrMacros());
        TextColumn::mixin(new Macros\TextColumnMacros());
        ViewFactory::mixin(new Macros\ViewMacros());

        Route::macro('findPageFromRoute', function () {
            /** @var Route */
            $route = $this;

            return Page::key($route->getName())->first();
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
    }

    protected function registerIcons()
    {
        $iconSets = new IconSets();
        $iconSets->addDefault('tabler', new TablerIconSet());

        $this->app->scoped(IconSets::class, fn () => $iconSets);
    }

    protected function setupBlade(): void
    {
        Blade::anonymousComponentPath(resource_path('views/public-components'), 'public');

        Blade::component('tips', Tips::class);
        Blade::component('email-layout', EmailLayout::class);

        Blade::directive('icon', [NovaBladeDirectives::class, 'icon']);
        Blade::directive('novaAdminScripts', [NovaBladeDirectives::class, 'novaAdminScripts']);
        Blade::directive('novaAdminStyles', [NovaBladeDirectives::class, 'novaAdminStyles']);
        Blade::directive('novaPublicScripts', [NovaBladeDirectives::class, 'novaPublicScripts']);
        Blade::directive('novaPublicStyles', [NovaBladeDirectives::class, 'novaPublicStyles']);
    }

    protected function registerLivewireComponents()
    {
        // Livewire::component('nova:editor', Editor::class);
        Livewire::component('rating', Rating::class);
        Livewire::component('icon-picker', IconPicker::class);
        Livewire::component('color-shade-picker', ColorShadePicker::class);
        Livewire::component('advanced-color-picker', AdvancedColorPicker::class);
        // Livewire::component('confirmation-modal', ConfirmationModal::class);
    }

    protected function registerResponseFilters(): void
    {
        $this->app->singleton(
            'nova.response-filters',
            fn () => new FiltersManager()
        );
    }

    protected function setupFactories()
    {
        Factory::guessFactoryNamesUsing(
            fn ($model) => 'Database\\Factories\\'.Str::afterLast($model, '\\').'Factory'
        );
    }

    protected function setupFilament(): void
    {
        FilamentColor::register($this->app['nova.settings']->appearance->getColors());

        FilamentColor::addShades('badge', [200, 300, 400, 700, 800, 950]);
        FilamentColor::addShades('tables::columns.toggle-column.on', [500, 900]);
        FilamentColor::addShades('forms::components.toggle.on', [500, 900]);

        FilamentIcon::register([
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

        TiptapEditor::configureUsing(function (TiptapEditor $component) {
            return $component->blocks($this->app[BlockManager::class]->blocks());
        });

        $this->app->bind(FilamentNotification::class, Notification::class);
    }

    protected function updateAboutCommand(): void
    {
        if (class_exists(AboutCommand::class)) {
            AboutCommand::add('Nova', [
                'Version' => 'v'.Nova::getVersion(),
            ]);
        }
    }

    protected function registerBlocks(): void
    {
        $blockManager = new BlockManager();

        $blockManager->registerPageBlocks([
            Blocks\Hero\ImageTilesHeroBlock::make(),
            Blocks\Hero\OffsetImageHeroBlock::make(),
            Blocks\Hero\SplitHeroBlock::make(),
            Blocks\Hero\StackedHeroBlock::make(),

            Blocks\Stats\SimpleStatsBlock::make(),
            Blocks\Stats\SplitStatsBlock::make(),

            Blocks\CallToAction\SimpleCallToActionBlock::make(),
            Blocks\CallToAction\SplitCallToActionBlock::make(),

            Blocks\Features\GridFeatureBlock::make(),
            Blocks\Features\CardsFeatureBlock::make(),
            Blocks\Features\AlternatingFeatureBlock::make(),

            Blocks\Logos\SimpleLogosBlock::make(),
            Blocks\Logos\SplitLogosBlock::make(),

            Blocks\Content\FreeformContentBlock::make(),

            Blocks\Stories\AlternatingStoriesBlock::make(),

            Blocks\Manifest\ManifestBlock::make(),

            Blocks\ContentRatings\CardsContentRatingsBlock::make(),
            Blocks\ContentRatings\GridContentRatingsBlock::make(),
            Blocks\ContentRatings\SplitContentRatingsBlock::make(),
        ]);

        $blockManager->registerFormBlocks([
            Fields\ShortTextField::make(),
            Fields\LongTextField::make(),
            Fields\NumberField::make(),
            Fields\EmailField::make(),
            Fields\DropdownField::make(),
            Fields\SelectOneField::make(),
        ]);

        $this->app->scoped(BlockManager::class, fn () => $blockManager);

        ScribbleFacade::registerTools(
            $this->app[BlockManager::class]->blocks()->toArray()
        );
    }

    protected function setupGlobalEventListeners(): void
    {
        Event::listen(Registered::class, SendEmailVerificationNotification::class);
        Event::listen(MessageSending::class, SetEmailSubjectPrefix::class);
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
