<?php

namespace Nova\Departments\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Departments\Models\Department;

class ViewDepartment extends SpotlightCommand
{
    protected string $name = 'View Department';

    protected string $description = 'View a department';

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('department')
                    ->setPlaceholder('Which department do you want to view?')
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
                    sprintf('Visit %s', $department->name)
                );
            });
    }

    public function execute(Spotlight $spotlight, Department $department): void
    {
        $spotlight->redirectRoute('departments.show', $department);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Department::class);
    }
}
