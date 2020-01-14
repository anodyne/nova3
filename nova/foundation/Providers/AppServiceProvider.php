<?php

namespace Nova\Foundation\Providers;

use Nova\Foundation\Nova;
use Nova\Foundation\Macros;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Blade;
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('nova.data.response', function ($app) {
            return [];
        });

        $this->app->bind('nova.data.frontend', function ($app) {
            return collect(['system' => [
                'name' => 'Nova NextGen',
            ]]);
        });
    }
}
