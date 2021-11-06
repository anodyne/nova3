<?php

declare(strict_types=1);

namespace Nova\Departments\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Departments\Models\Department;

class AddDepartment extends SpotlightCommand
{
    protected string $name = 'Add Department';

    protected string $description = 'Add a new department';

    protected array $synonyms = [
        'create department',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('departments.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Department::class);
    }
}
