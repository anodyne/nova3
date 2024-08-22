<?php

declare(strict_types=1);

namespace Nova\Departments\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

class ViewPosition extends SpotlightCommand
{
    protected string $name = 'View Position';

    protected string $description = 'View a position';

    protected array $synonyms = [
        'show position',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('position')
                    ->setPlaceholder('Which positions do you want to view?')
            );
    }

    public function searchPosition($query)
    {
        return Position::where('name', 'like', "%{$query}%")
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
        $spotlight->redirectRoute('admin.positions.show', $position);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Department::class);
    }
}
