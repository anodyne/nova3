<?php

namespace Nova\Departments\Spotlight;

use Illuminate\Http\Request;
use LivewireUI\Spotlight\Spotlight;
use Illuminate\Support\Facades\Gate;
use Nova\Departments\Models\Department;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightSearchResult;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightCommandDependencies;

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

    public function searchDepartment(Request $request, $query)
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
