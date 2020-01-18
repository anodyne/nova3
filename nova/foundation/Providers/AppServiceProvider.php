<?php

namespace Nova\Foundation\Providers;

use Inertia\Inertia;
use Nova\Foundation\Nova;
use Nova\Foundation\Macros;
use Illuminate\Routing\Route;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory as ViewFactory;

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

        Blade::component('components.partials.page-header', 'pageHeader');

        $this->app->bind(Nova::class, function ($app) {
            return new Nova;
        });

        Route::mixin(new Macros\RouteMacros);
        ViewFactory::mixin(new Macros\ViewMacros);
        RedirectResponse::mixin(new Macros\RedirectResponseMacros);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerInertia();

        $this->app->bind('nova.data.response', function ($app) {
            return [];
        });

        $this->app->bind('nova.data.frontend', function ($app) {
            return collect(['system' => [
                'name' => 'Nova NextGen',
            ]]);
        });
    }

    protected function registerInertia()
    {
        Inertia::version(function () {
            return md5_file(base_path('dist/mix-manifest.json'));
        });

        Inertia::share([
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
}
