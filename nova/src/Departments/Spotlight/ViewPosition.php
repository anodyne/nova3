<?php

namespace Nova\Departments\Spotlight;

use Illuminate\Http\Request;
use LivewireUI\Spotlight\Spotlight;
use Illuminate\Support\Facades\Gate;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightSearchResult;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightCommandDependencies;

class ViewPosition extends SpotlightCommand
{
    protected string $name = 'View Position';

    protected string $description = 'View a position';

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('position')
                    ->setPlaceholder('Which positions do you want to view?')
            );
    }

    public function searchPosition(Request $request, $query)
    {
        return Position::where('name', 'like', "%${query}%")
            ->get()
            ->map(function ($position) {
                return new SpotlightSearchResult(
                    $position->id,
                    $position->name,
                    sprintf('View %s', $position->name)
                );
            });
    }

    public function execute(Spotlight $spotlight, Position $position): void
    {
        $spotlight->redirectRoute('positions.show', $position);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Department::class);
    }
}
