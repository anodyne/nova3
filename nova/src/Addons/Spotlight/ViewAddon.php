<?php

declare(strict_types=1);

namespace Nova\Addons\Spotlight;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Addons\Models\Addon;

class ViewAddon extends SpotlightCommand
{
    protected string $description = 'View a add-on';

    protected string $name = 'View Add-on';

    /** @var array<int, string> */
    protected array $synonyms = [
        'show an add-on',
        'show an extension',
        'show a genre',
        'show a rank set',
        'display an add-on',
        'display an extension',
        'display a genre',
        'display a rank set',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('addon')
                    ->setPlaceholder('Which add-on do you want to view?')
            );
    }

    public function execute(Spotlight $spotlight, Addon $addon): void
    {
        $spotlight->redirectRoute('admin.addons.show', $addon);
    }

    /**
     * @return Collection<int, Addon>
     */
    public function searchAddon(string $query): Collection
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
        return Gate::allows('view', new Addon);
    }
}
