<?php

declare(strict_types=1);

namespace Nova;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use LivewireUI\Spotlight\Spotlight;
use Nova\Foundation\Application;
use Nova\Foundation\Nova;
use Spatie\PrefixedIds\PrefixedIds;

/** @property Application $app */
abstract class DomainServiceProvider extends ServiceProvider
{
    /** @return array<string, class-string> */
    public function bladeComponents(): array
    {
        return [];
    }

    /** @return array<int, class-string> */
    public function consoleCommands(): array
    {
        return [];
    }

    /** @return array<class-string, array<int, class-string>> */
    public function eventListeners(): array
    {
        return [];
    }

    /** @return array<string, class-string> */
    public function livewireComponents(): array
    {
        return [];
    }

    /** @return array<string, class-string<Model>> */
    public function morphMaps(): array
    {
        return [];
    }

    /** @return array<string, class-string> */
    public function policies(): array
    {
        return [];
    }

    /** @return array<string, class-string> */
    public function prefixedIds(): array
    {
        return [];
    }

    public function routes(): ?string
    {
        return null;
    }

    public function boot(): void
    {
        $this->domainBooting();

        $this->registerConsoleCommands();
        $this->registerListeners();
        $this->registerPolicies();
        $this->registerPrefixedIds();
        $this->registerRoutes();
        $this->registerBladeComponents();
        $this->registerLivewireComponents();
        $this->registerSpotlightCommands();

        $this->domainBooted();
    }

    public function register(): void
    {
        $this->registerMorphMaps();
    }

    /** @return array<int, class-string> */
    public function spotlightCommands(): array
    {
        return [];
    }

    public function domainBooting(): void {}

    public function domainBooted(): void {}

    /**
     * Allow a domain service provider to specify additional actions to run
     * before the register process starts.
     *
     * @return void
     */
    protected function registeringDomain() {}

    /**
     * Allow a domain service provider to specify additional actions to run
     * after the register process runs.
     *
     * @return void
     */
    protected function registeredDomain() {}

    private function registerSpotlightCommands(): void
    {
        if (Nova::isInstalled()) {
            collect($this->spotlightCommands())->each(fn (string $command) => Spotlight::registerCommand($command));
        }
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
        collect($this->eventListeners())->each(function ($listeners, $event): void {
            collect($listeners)->each(
                fn ($listener) => Event::listen($event, $listener)
            );
        });
    }

    private function registerLivewireComponents(): void
    {
        collect($this->livewireComponents())
            ->each(fn ($component, $alias) => Livewire::addComponent(name: $alias, class: $component));
    }

    private function registerMorphMaps(): void
    {
        Relation::enforceMorphMap($this->morphMaps());
    }

    private function registerPolicies(): void
    {
        collect($this->policies())
            ->each(fn ($policy, $model) => Gate::policy($model, $policy));
    }

    private function registerPrefixedIds(): void
    {
        PrefixedIds::registerModels($this->prefixedIds());
    }

    private function registerRoutes(): void
    {
        if ($routePath = $this->routes()) {
            Route::middleware('web')->group([$routePath]);
        }
    }
}
