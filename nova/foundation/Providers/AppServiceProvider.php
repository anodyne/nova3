<?php

namespace Nova\Foundation\Providers;

use Nova\Pages\Page;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Nova\Foundation\Nova;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::macro('findPageFromRoute', function () {
            return Page::where('key', $this->getName())->first();
        });

        // Make sure the file finder can find Javascript files
        view()->addExtension('js', 'file');

        Blade::component('components.partials.page-header', 'pageHeader');

        $this->app->bind(Nova::class, function ($app) {
            return new Nova;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('nova.data.frontend', function ($app) {
            return collect(['system' => [
                'name' => 'Nova NextGen'
            ]]);
        });
    }
}
