<?php

declare(strict_types=1);

namespace Nova\Menus\Spotlight;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Menus\Models\MenuItem;

class EditMenuItem extends SpotlightCommand
{
    protected string $name = 'Edit Menu Item';

    protected string $description = 'Edit a menu item';

    /** @var list<string> */
    protected array $synonyms = [
        'update menu item',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('menuItem')
                    ->setPlaceholder('Which menu item do you want to edit?')
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchMenuItem(string $query): Collection
    {
        return MenuItem::where('label', 'like', "%{$query}%")
            ->get()
            ->map(fn (MenuItem $menuItem): SpotlightSearchResult => new SpotlightSearchResult(
                $menuItem->id,
                $menuItem->label,
                sprintf('Edit %s menu item', $menuItem->label)
            ));
    }

    public function execute(Spotlight $spotlight, MenuItem $menuItem): void
    {
        $spotlight->redirectRoute('admin.menu-items.edit', $menuItem);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new MenuItem);
    }
}
