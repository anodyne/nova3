<?php

namespace Nova\Foundation\Providers;

use Nova\Foundation\Macros;
use Illuminate\Routing\Route;
use Nova\Foundation\NovaManager;
use Nova\Foundation\Icons\IconSets;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nova\Foundation\Icons\FluentIconSet;
use Nova\Foundation\NovaBladeDirectives;
use Nova\Foundation\Icons\FeatherIconSet;
use Nova\Foundation\View\Components\Badge;
use Illuminate\View\Factory as ViewFactory;
use Nova\Foundation\View\Components\Avatar;
use Nova\Foundation\View\Components\Dropdown;
use Nova\Foundation\View\Components\AvatarGroup;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerNovaSingleton();
    }

    public function boot()
    {
        // Make sure the file finder can find Javascript files
        $this->app['view']->addExtension('js', 'file');

        Paginator::useTailwind();

        $this->registerMacros();
        $this->registerIcons();
        $this->registerBladeDirectives();
        $this->registerBladeComponents();
        $this->registerLivewireComponents();
    }

    protected function registerNovaSingleton()
    {
        $this->app->singleton('nova', NovaManager::class);
    }

    protected function registerMacros()
    {
        RedirectResponse::mixin(new Macros\RedirectResponseMacros);
        Route::mixin(new Macros\RouteMacros);
        ViewFactory::mixin(new Macros\ViewMacros);
    }

    protected function registerIcons()
    {
        $iconSets = new IconSets;
        $iconSets->add('feather', new FeatherIconSet);
        $iconSets->add('fluent', new FluentIconSet);

        $this->app->instance(IconSets::class, $iconSets);
    }

    protected function registerBladeComponents()
    {
        Blade::component('badge', Badge::class);
        Blade::component('avatar', Avatar::class);
        Blade::component('dropdown', Dropdown::class);
        Blade::component('avatar-group', AvatarGroup::class);
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('icon', [NovaBladeDirectives::class, 'icon']);
        Blade::directive('novaScripts', [NovaBladeDirectives::class, 'novaScripts']);
        Blade::directive('novaStyles', [NovaBladeDirectives::class, 'novaStyles']);
    }

    protected function registerLivewireComponents()
    {
    }
}
