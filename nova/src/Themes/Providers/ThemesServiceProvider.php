<?php

namespace Nova\Themes\Providers;

use Nova\Themes\BaseTheme;
use Illuminate\Support\ServiceProvider;
use Nova\Themes\Console\Commands\ThemeMakeCommand;

class ThemesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ThemeMakeCommand::class,
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('nova.theme', function ($app) {
            return new \Themes\Pulsar\Theme('pulsar');
        });
    }
}