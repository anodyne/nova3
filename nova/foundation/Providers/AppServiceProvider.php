<?php

declare(strict_types=1);

namespace Nova\Foundation\Providers;

use Carbon\CarbonImmutable;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Factory as ViewFactory;
use Livewire\Livewire;
use Nova\Foundation\Environment\Environment;
use Nova\Foundation\Filament\Notifications\Notification;
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
use Nova\Foundation\View\Components\EmailLayout;
use Nova\Foundation\View\Components\Tips;
use Nova\Navigation\Models\Navigation;
use Nova\Settings\Models\Settings;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerNovaSingleton();
        $this->registerResponseFilters();
        $this->registerFilamentBindings();
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
        Route::mixin(new Macros\RouteMacros());
        Str::mixin(new Macros\StrMacros());
        TextColumn::mixin(new Macros\TextColumnMacros());
        ViewFactory::mixin(new Macros\ViewMacros());
    }

    protected function registerIcons()
    {
        $iconSets = new IconSets();
        $iconSets->addDefault('tabler', new TablerIconSet());

        $this->app->scoped(IconSets::class, fn () => $iconSets);
    }

    protected function registerBladeComponents()
    {
        Blade::component('tips', Tips::class);
        Blade::component('email-layout', EmailLayout::class);
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('icon', [NovaBladeDirectives::class, 'icon']);
        Blade::directive('novaScripts', [NovaBladeDirectives::class, 'novaScripts']);
        Blade::directive('novaStyles', [NovaBladeDirectives::class, 'novaStyles']);
    }

    protected function registerLivewireComponents()
    {
        // Livewire::component('nova:editor', Editor::class);
        Livewire::component('rating', Rating::class);
        Livewire::component('icon-picker', IconPicker::class);
        Livewire::component('color-shade-picker', ColorShadePicker::class);
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
            'tables::search-field' => iconName('search'),
            'modal.close-button' => iconName('x'),
        ]);

        Table::configureUsing(function (Table $table) {
            $table
                ->filtersTriggerAction(function ($action) {
                    return $action->icon(iconName('filter'))->size('lg')->color('gray');
                })
                ->toggleColumnsTriggerAction(function ($action) {
                    return $action->icon(iconName('columns'))->size('lg')->color('gray');
                })
                ->reorderRecordsTriggerAction(function ($action, bool $isReordering) {
                    return $action
                        ->icon($isReordering ? iconName('check') : iconName('arrows-sort'))
                        ->size('lg')
                        ->color($isReordering ? 'primary' : 'gray');
                });
        });

        $this->app->bind(FilamentNotification::class, Notification::class);
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
