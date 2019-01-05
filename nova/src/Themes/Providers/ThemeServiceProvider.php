<?php

namespace Nova\Themes\Providers;

use Nova\Themes\BaseTheme;
use Illuminate\Support\ServiceProvider;
use Nova\Themes\Console\Commands\ThemeMakeCommand;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            ThemeMakeCommand::class,
        ]);

        $this->app->bind('nova.theme', function ($app) {
            return new \Themes\Pulsar\Theme;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}