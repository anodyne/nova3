<?php

declare(strict_types=1);

namespace Nova\Roles\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Roles\Models\Role;

class EditRole extends SpotlightCommand
{
    protected string $name = 'Edit Role';

    protected string $description = 'Edit a role';

    protected array $synonyms = [
        'update existing role',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('role')
                    ->setPlaceholder('Which role do you want to edit?')
            );
    }

    public function searchRole($query)
    {
        return Role::query()
            ->searchFor($query)
            ->get()
            ->map(fn (Role $role) => new SpotlightSearchResult(
                $role->id,
                $role->display_name,
                sprintf('Edit %s', $role->display_name)
            ));
    }

    public function execute(Spotlight $spotlight, Role $role): void
    {
        $spotlight->redirectRoute('roles.edit', $role);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new Role);
    }
}
