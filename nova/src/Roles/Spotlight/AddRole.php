<?php

declare(strict_types=1);

namespace Nova\Roles\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Roles\Models\Role;

class AddRole extends SpotlightCommand
{
    protected string $name = 'Add Role';

    protected string $description = 'Add a new role';

    protected array $synonyms = [
        'create new role',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.roles.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Role::class);
    }
}
