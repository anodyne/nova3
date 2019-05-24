<?php

namespace Nova\Themes\Providers;

use Nova\Themes\Models\Theme;
use Illuminate\Support\Facades\Gate;
use Nova\Themes\Policies\ThemePolicy;
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
        Gate::policy(Theme::class, ThemePolicy::class);

        $this->commands([
            ThemeMakeCommand::class,
        ]);

        $theme = new \Themes\Pulsar\Theme;

        $this->app->instance('nova.theme', $theme);

        $this->app->extend('nova.data.frontend', function ($data) use ($theme) {
            $data->put('theme', $theme);
            $data->put('icons', $theme->iconMap());

            return $data;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
