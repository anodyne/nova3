<?php

declare(strict_types=1);

namespace Nova;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use LivewireUI\Spotlight\Spotlight;

abstract class DomainServiceProvider extends ServiceProvider
{
    public function bladeComponents(): array
    {
        return [];
    }

    public function consoleCommands(): array
    {
        return [];
    }

    public function eventListeners(): array
    {
        return [];
    }

    public function livewireComponents(): array
    {
        return [];
    }

    public function morphMaps(): array
    {
        return [];
    }

    public function policies(): array
    {
        return [];
    }

    public function responsables(): array
    {
        return [];
    }

    public function routes(): array
    {
        return [];
    }

    public function boot()
    {
        $this->domainBooting();

        $this->registerConsoleCommands();
        $this->registerListeners();
        $this->registerPolicies();
        $this->registerRoutes();
        $this->registerBladeComponents();
        $this->registerLivewireComponents();
        $this->registerSpotlightCommands();

        $this->domainBooted();
    }

    public function register()
    {
        $this->registerMorphMaps();
        $this->registerResponsables();
    }

    public function spotlightCommands(): array
    {
        return [];
    }

    public function domainBooting(): void
    {
    }

    public function domainBooted(): void
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
        collect($this->bladeComponents())
            ->each(fn ($component, $alias) => Blade::component($alias, $component));
    }

    private function registerConsoleCommands(): void
    {
        $this->commands($this->consoleCommands());
    }

    private function registerListeners(): void
    {
        collect($this->eventListeners())->each(function ($listeners, $event) {
            collect($listeners)->each(
                fn ($listener) => Event::listen($event, $listener)
            );
        });
    }

    private function registerLivewireComponents(): void
    {
        collect($this->livewireComponents())
            ->each(fn ($component, $alias) => Livewire::component($alias, $component));
    }

    private function registerMorphMaps(): void
    {
        Relation::morphMap($this->morphMaps());
    }

    private function registerPolicies(): void
    {
        collect($this->policies())
            ->each(fn ($policy, $model) => Gate::policy($model, $policy));
    }

    private function registerResponsables(): void
    {
        collect($this->responsables())->each(function ($responsable) {
            $this->app->singleton($responsable, function ($app) use ($responsable) {
                $page = optional($this->app['request']->route())->findPageFromRoute();

                return new $responsable($page, $app);
            });
        });
    }

    private function registerRoutes(): void
    {
        Route::middleware('web')->group(function () {
            collect($this->routes())->each(function ($route, $uri) {
                $verb = $route['verb'];
                unset($route['verb']);
                Route::{$verb}($uri, $route);
            });
        });
    }
}
