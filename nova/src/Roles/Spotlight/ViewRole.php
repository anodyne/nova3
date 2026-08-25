<?php

declare(strict_types=1);

namespace Nova\Roles\Spotlight;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Roles\Models\Role;

class ViewRole extends SpotlightCommand
{
    protected string $name = 'View Role';

    protected string $description = 'View a role';

    /** @var list<string> */
    protected array $synonyms = [
        'show a role',
        'display a role',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('role')
                    ->setPlaceholder('Which role do you want to view?')
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchRole(string $query): Collection
    {
        return Role::query()
            ->searchFor($query)
            ->get()
            ->map(fn (Role $role): SpotlightSearchResult => new SpotlightSearchResult(
                $role->id,
                $role->display_name,
                sprintf('Edit %s', $role->display_name)
            ));
    }

    public function execute(Spotlight $spotlight, Role $role): void
    {
        $spotlight->redirectRoute('admin.roles.show', $role);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('view', new Role);
    }
}
