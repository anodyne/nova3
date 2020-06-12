<?php

namespace Nova;

use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

abstract class DomainServiceProvider extends ServiceProvider
{
    protected $bladeComponents = [];

    protected $commands = [];

    protected $listeners = [];

    protected $livewireComponents = [];

    protected $morphMaps = [];

    protected $policies = [];

    protected $responsables = [];

    protected $routes = [];

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->bootingDomain();

        $this->registerBladeComponents();
        $this->registerCommands();
        $this->registerListeners();
        $this->registerLivewireComponents();
        $this->registerPolicies();
        $this->registerRoutes();

        $this->bootedDomain();
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->registeringDomain();

        $this->registerMorphMaps();
        $this->registerResponsables();

        $this->registeredDomain();
    }

    /**
     * Allow a domain service provider to specify additional actions to run
     * before the boot process starts.
     *
     * @return void
     */
    protected function bootingDomain()
    {
    }

    /**
     * Allow a domain service provider to specify additional actions to run
     * after the boot process runs.
     *
     * @return void
     */
    protected function bootedDomain()
    {
    }

    /**
     * Allow a domain service provider to specify additional actions to run
     * before the register process starts.
     *
     * @return void
     */
    protected function registeringDomain()
    {
    }

    /**
     * Allow a domain service provider to specify additional actions to run
     * after the register process runs.
     *
     * @return void
     */
    protected function registeredDomain()
    {
    }

    /**
     * Register any Blade components.
     *
     * @return void
     */
    private function registerBladeComponents()
    {
        collect($this->bladeComponents)->each(function ($component, $alias) {
            Blade::component($alias, $component);
        });
    }

    /**
     * Register any Artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        $this->commands($this->commands);
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
     * Register any Livewire components.
     *
     * @return void
     */
    private function registerLivewireComponents()
    {
        collect($this->livewireComponents)->each(function ($component, $alias) {
            Livewire::component($alias, $component);
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
