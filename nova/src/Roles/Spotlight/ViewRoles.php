<?php

declare(strict_types=1);

namespace Nova\Roles\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Roles\Models\Role;

class ViewRoles extends SpotlightCommand
{
    protected string $name = 'View Roles';

    protected string $description = 'View all roles';

    protected array $synonyms = [
        'show all roles',
        'display all roles',
        'list all roles',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('roles.index');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Role::class);
    }
}
