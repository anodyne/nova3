<?php

namespace Nova;

use Livewire\Livewire;
use LivewireUI\Spotlight\Spotlight;
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

        $this->registerCommands();
        $this->registerListeners();
        $this->registerPolicies();
        $this->registerRoutes();
        $this->registerBladeComponents();
        $this->registerLivewireComponents();
        $this->registerSpotlightCommands();

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

    public function spotlightCommands(): array
    {
        return [];
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

    private function registerSpotlightCommands(): void
    {
        collect($this->spotlightCommands())
            ->each(fn ($command) => Spotlight::registerCommand($command));
    }

    private function registerBladeComponents(): void
    {
        collect($this->bladeComponents)
            ->each(fn ($component, $alias) => Blade::component($alias, $component));
    }

    private function registerCommands(): void
    {
        $this->commands($this->commands);
    }

    private function registerListeners(): void
    {
        collect($this->listeners)->each(function ($listeners, $event) {
            collect($listeners)->each(function ($listener) use ($event) {
                Event::listen($event, $listener);
            });
        });
    }

    private function registerLivewireComponents(): void
    {
        collect($this->livewireComponents)
            ->each(fn ($component, $alias) => Livewire::component($alias, $component));
    }

    private function registerMorphMaps(): void
    {
        Relation::morphMap($this->morphMaps);
    }

    private function registerPolicies(): void
    {
        collect($this->policies)
            ->each(fn ($policy, $model) => Gate::policy($model, $policy));
    }

    private function registerResponsables(): void
    {
        collect($this->responsables)->each(function ($responsable) {
            $this->app->singleton($responsable, function ($app) use ($responsable) {
                $page = optional($this->app['request']->route())->findPageFromRoute();

                return new $responsable($page, $app);
            });
        });
    }

    private function registerRoutes(): void
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
