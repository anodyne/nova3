<?php

namespace Nova;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

abstract class DomainServiceProvider extends ServiceProvider
{
    protected $commands = [];

    protected $listeners = [];

    protected $morphMaps = [];

    protected $policies = [];

    protected $responsables = [];

    protected $routes = [];

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->registerCommands();

        $this->registerListeners();

        $this->registerPolicies();

        $this->registerRoutes();

        $this->bootActions();
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->registerMorphMaps();

        $this->registerResponsables();

        $this->registerActions();
    }

    /**
     * Allow a domain service provider to specify additional actions to run
     * at the end of the boot process.
     *
     * @return void
     */
    protected function bootActions()
    {
    }

    /**
     * Allow a domain service provider to specify additional actions to run
     * at the end of the register process.
     *
     * @return void
     */
    protected function registerActions()
    {
    }

    /**
     * Register any Artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register any event listeners.
     *
     * @return void
     */
    private function registerListeners()
    {
        collect($this->listeners)->each(function ($listeners, $event) {
            collect($listeners)->each(function ($listener) use ($event) {
                Event::listen($event, $listener);
            });
        });
    }

    /**
     * Register any morph mappings.
     *
     * @return void
     */
    private function registerMorphMaps()
    {
        Relation::morphMap($this->morphMaps);
    }

    /**
     * Register any policies.
     *
     * @return void
     */
    private function registerPolicies()
    {
        collect($this->policies)->each(function ($policy, $model) {
            Gate::policy($model, $policy);
        });
    }

    /**
     * Register any Responsable classes.
     *
     * @return void
     */
    private function registerResponsables()
    {
        collect($this->responsables)->each(function ($responsable) {
            $this->app->singleton($responsable, function ($app) use ($responsable) {
                $page = optional($this->app['request']->route())->findPageFromRoute();

                return new $responsable($page, $app);
            });
        });
    }

    /**
     * Register any protected routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::middleware('web')->group(function () {
            collect($this->routes)->each(function ($route, $uri) {
                $verb = $route['verb'];
                unset($route['verb']);
                Route::{$verb}($uri, $route);
            });
        });
    }
}
