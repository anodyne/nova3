<?php

namespace Nova\Foundation\Providers;

use Inertia\Inertia;
use Livewire\Livewire;
use Nova\Foundation\Macros;
use Illuminate\Routing\Route;
use Nova\Foundation\NovaManager;
use Nova\Foundation\Icons\IconSets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Nova\Foundation\NovaBladeDirectives;
use Nova\Foundation\Icons\FeatherIconSet;
use Illuminate\View\Factory as ViewFactory;
use Nova\Foundation\View\Components\FormField;
use Illuminate\Pagination\LengthAwarePaginator;
use Nova\Foundation\Http\Livewire\PasswordField;
use Nova\Foundation\View\Components\ToggleSwitch;

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

        $this->registerInertia();
        $this->registerMacros();
        $this->registerLengthAwarePaginator();
        $this->registerBladeDirectives();
        $this->registerBladeComponents();
        $this->registerLivewireComponents();
        $this->registerIcons();
    }

    protected function registerNovaSingleton()
    {
        $this->app->singleton('nova', NovaManager::class);
    }

    protected function registerInertia()
    {
        Inertia::version(function () {
            return md5_file(base_path('dist/mix-manifest.json'));
        });

        Inertia::share([
            'auth' => function () {
                return [
                    'user' => Auth::user() ? [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'state' => Auth::user()->state,
                        'avatar_url' => Auth::user()->avatar_url,
                    ] : null,
                ];
            },
            'errors' => function () {
                return Session::has('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
            'toast' => function () {
                return Session::has('nova.toast')
                    ? Session::get('nova.toast')
                    : (object) [];
            },
        ]);
    }

    protected function registerLengthAwarePaginator()
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new \Nova\Foundation\LengthAwarePaginator(...array_values($values));
        });
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

        $this->app->instance(IconSets::class, $iconSets);
    }

    protected function registerBladeComponents()
    {
        Blade::component('form-field', FormField::class);
        Blade::component('toggle-switch', ToggleSwitch::class);
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('icon', [NovaBladeDirectives::class, 'icon']);
        Blade::directive('novaScripts', [NovaBladeDirectives::class, 'novaScripts']);
        Blade::directive('novaStyles', [NovaBladeDirectives::class, 'novaStyles']);
    }

    protected function registerLivewireComponents()
    {
        Livewire::component('password-field', PasswordField::class);
    }
}
