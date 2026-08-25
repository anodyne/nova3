<?php

declare(strict_types=1);

namespace Nova\Departments\Spotlight;

use Illuminate\Support\Collection;
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

    /** @var array<string> */
    protected array $synonyms = [
        'update department',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('department')
                    ->setPlaceholder('Which department do you want to edit?')
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchDepartment(string $query): Collection
    {
        return Department::where('name', 'like', "%{$query}%")
            ->get()
            ->map(fn (Department $department): SpotlightSearchResult => new SpotlightSearchResult(
                $department->id,
                $department->name,
                sprintf('Edit %s department', $department->name)
            ));
    }

    public function execute(Spotlight $spotlight, Department $department): void
    {
        $spotlight->redirectRoute('admin.departments.edit', $department);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new Department);
    }
}
