<?php

namespace Nova\Departments\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use Illuminate\Support\Facades\Gate;
use Nova\Departments\Models\Department;
use LivewireUI\Spotlight\SpotlightCommand;

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
