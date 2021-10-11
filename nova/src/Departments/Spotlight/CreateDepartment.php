<?php

declare(strict_types=1);

namespace Nova\Departments\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Departments\Models\Department;

class CreateDepartment extends SpotlightCommand
{
    protected string $name = 'Create Department';

    protected string $description = 'Create a new department';

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('departments.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Department::class);
    }
}
