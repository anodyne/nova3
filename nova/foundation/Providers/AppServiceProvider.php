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
use Illuminate\Pagination\LengthAwarePaginator;
use Nova\Foundation\Http\Livewire\PasswordField;
use Nova\Foundation\View\Components\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Make sure the file finder can find Javascript files
        $this->app['view']->addExtension('js', 'file');

        $this->app->singleton('nova', NovaManager::class);

        $this->registerBladeDirectives();

        $this->registerLivewireComponents();

        $this->registerIcons();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMacros();

        $this->registerInertia();

        $this->registerLengthAwarePaginator();

        // $this->app->bind('nova.data.response', function ($app) {
        //     return [];
        // });

        // $this->app->bind('nova.data.frontend', function ($app) {
        //     return collect(['system' => [
        //         'name' => 'Nova NextGen',
        //     ]]);
        // });
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
        Route::mixin(new Macros\RouteMacros);
        ViewFactory::mixin(new Macros\ViewMacros);
        RedirectResponse::mixin(new Macros\RedirectResponseMacros);
    }

    protected function registerIcons()
    {
        $iconSets = new IconSets;
        $iconSets->add('feather', new FeatherIconSet);

        $this->app->instance(IconSets::class, $iconSets);
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('icon', [NovaBladeDirectives::class, 'icon']);
        Blade::directive('novaScripts', [NovaBladeDirectives::class, 'novaScripts']);
    }

    protected function registerLivewireComponents()
    {
        Livewire::component('password-field', PasswordField::class);
    }
}
