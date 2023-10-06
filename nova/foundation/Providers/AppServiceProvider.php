<?php

declare(strict_types=1);

namespace Nova\Foundation\Providers;

use Filament\Support\Colors\ColorManager;
use Filament\Support\Icons\Icon;
use Filament\Support\Icons\IconManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Factory as ViewFactory;
use Livewire\Livewire;
use Nova\Foundation\Environment\Environment;
use Nova\Foundation\Icons\FluentFilledIconSet;
use Nova\Foundation\Icons\FluentOutlineIconSet;
use Nova\Foundation\Icons\IconSets;
use Nova\Foundation\Icons\TablerIconSet;
use Nova\Foundation\Livewire\ColorShadePicker;
use Nova\Foundation\Livewire\ConfirmationModal;
use Nova\Foundation\Livewire\Editor;
use Nova\Foundation\Livewire\IconPicker;
use Nova\Foundation\Livewire\Rating;
use Nova\Foundation\Macros;
use Nova\Foundation\Nova;
use Nova\Foundation\NovaBladeDirectives;
use Nova\Foundation\NovaManager;
use Nova\Foundation\Responses\FiltersManager;
use Nova\Foundation\View\Components\Badge;
use Nova\Foundation\View\Components\ContentBox;
use Nova\Foundation\View\Components\Dropdown;
use Nova\Foundation\View\Components\Tips;
use Nova\Navigation\Models\Navigation;
use Nova\Settings\Models\Settings;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        clock()->event('app service provider register')->color('purple')->begin();

        $this->registerNovaSingleton();
        $this->registerResponseFilters();
        $this->registerFilamentBindings();

        clock()->event('app service provider register')->end();
    }

    public function boot(): void
    {
        clock()->event('app service provider boot')->color('green')->begin();

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

        $this->registerMacros();
        $this->updateAboutCommand();
        $this->setupFactories();
        $this->registerIcons();
        $this->registerBladeDirectives();
        $this->registerBladeComponents();

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
        }

        clock()->event('app service provider boot')->end();
    }

    protected function registerNovaSingleton()
    {
        $this->app->scoped('nova', NovaManager::class);
    }

    protected function registerMacros()
    {
        Arr::mixin(new Macros\ArrMacros());
        Redirector::mixin(new Macros\ToastMacros());
        RedirectResponse::mixin(new Macros\ToastMacros());
        Route::mixin(new Macros\RouteMacros());
        Str::mixin(new Macros\StrMacros());
        TextColumn::mixin(new Macros\TextColumnMacros());
        ViewFactory::mixin(new Macros\ViewMacros());
    }

    protected function registerIcons()
    {
        $iconSets = new IconSets();
        $iconSets->addDefault('tabler', new TablerIconSet());
        $iconSets->add('fluent-outline', new FluentOutlineIconSet());
        $iconSets->add('fluent-filled', new FluentFilledIconSet());

        $this->app->scoped(IconSets::class, fn () => $iconSets);
    }

    protected function registerBladeComponents()
    {
        Blade::component('badge', Badge::class);
        Blade::component('content-box', ContentBox::class);
        // Blade::component('dropdown', Dropdown::class);
        Blade::component('tips', Tips::class);
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('icon', [NovaBladeDirectives::class, 'icon']);
        Blade::directive('novaScripts', [NovaBladeDirectives::class, 'novaScripts']);
        Blade::directive('novaStyles', [NovaBladeDirectives::class, 'novaStyles']);
    }

    protected function registerLivewireComponents()
    {
        Livewire::component('nova:editor', Editor::class);
        Livewire::component('rating', Rating::class);
        Livewire::component('icon-picker', IconPicker::class);
        Livewire::component('color-shade-picker', ColorShadePicker::class);
        Livewire::component('confirmation-modal', ConfirmationModal::class);
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
        app(ColorManager::class)->register($this->app['nova.settings']->appearance->getColors());

        app(IconManager::class)->register([
            'filament-tables::search-input.prefix' => Icon::make(iconName('search')),
            'support::modal.close-button' => Icon::make(iconName('dismiss')),
        ]);

        Table::configureUsing(function (Table $table) {
            $table
                ->filtersTriggerAction(fn ($action) => $action->icon(iconName('filter'))->size('lg')->color('gray'))
                ->toggleColumnsTriggerAction(fn ($action) => $action->icon(iconName('columns'))->size('lg')->color('gray'))
                ->reorderRecordsTriggerAction(fn ($action, bool $isReordering) => $action
                    ->icon($isReordering ? iconName('check') : iconName('arrows-sort'))
                    ->size('lg')
                    ->color($isReordering ? 'primary' : 'gray')
                );
        });
    }

    protected function updateAboutCommand(): void
    {
        if (class_exists(AboutCommand::class)) {
            AboutCommand::add('Nova', [
                'Version' => Nova::getVersion(),
            ]);
        }
    }

    protected function registerFilamentBindings(): void
    {
        $this->app->bind(
            \Filament\Support\Assets\Js::class,
            \Nova\Foundation\Filament\Assets\Js::class
        );

        $this->app->bind(
            \Filament\Support\Assets\Css::class,
            \Nova\Foundation\Filament\Assets\Css::class
        );

        $this->app->bind(
            \Filament\Support\Assets\AlpineComponent::class,
            \Nova\Foundation\Filament\Assets\AlpineComponent::class
        );
    }
}
