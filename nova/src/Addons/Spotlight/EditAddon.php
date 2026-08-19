<?php

declare(strict_types=1);

namespace Nova\Addons\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Addons\Models\Addon;

class EditAddon extends SpotlightCommand
{
    protected string $description = 'Edit a add-on';

    protected string $name = 'Edit Add-on';

    protected array $synonyms = [
        'update existing add-on',
        'update existing extension',
        'update existing genre',
        'update existing rank set',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('addon')
                    ->setPlaceholder('Which add-on do you want to edit?')
            );
    }

    public function execute(Spotlight $spotlight, Addon $addon): void
    {
        $spotlight->redirectRoute('admin.addons.edit', $addon);
    }

    public function searchAddon($query)
    {
        return Addon::query()
            ->searchFor('name', $query)
            ->get()
            ->map(fn (Addon $addon): SpotlightSearchResult => new SpotlightSearchResult(
                $addon->id,
                $addon->name,
                sprintf('Edit %s', $addon->name)
            ));
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new Addon);
    }
}
