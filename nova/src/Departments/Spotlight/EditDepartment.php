<?php

namespace Nova\Departments\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Departments\Models\Department;

class EditDepartment extends SpotlightCommand
{
    protected string $name = 'Edit Department';

    protected string $description = 'Edit a department';

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('department')
                    ->setPlaceholder('Which department do you want to edit?')
            );
    }

    public function searchDepartment($query)
    {
        return Department::where('name', 'like', "%${query}%")
            ->get()
            ->map(function ($department) {
                return new SpotlightSearchResult(
                    $department->id,
                    $department->name,
                    sprintf('Edit %s department', $department->name)
                );
            });
    }

    public function execute(Spotlight $spotlight, Department $department): void
    {
        $spotlight->redirectRoute('departments.edit', $department);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new Department);
    }
}
