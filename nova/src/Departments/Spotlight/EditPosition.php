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

class EditPosition extends SpotlightCommand
{
    protected string $name = 'Edit Position';

    protected string $description = 'Edit a position';

    protected array $synonyms = [
        'update position',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('position')
                    ->setPlaceholder('Which position do you want to edit?')
            );
    }

    public function searchPosition($query)
    {
        return Position::where('name', 'like', "%${query}%")
            ->get()
            ->map(function ($position) {
                return new SpotlightSearchResult(
                    $position->id,
                    $position->name,
                    sprintf('Edit %s position', $position->name)
                );
            });
    }

    public function execute(Spotlight $spotlight, Position $position): void
    {
        $spotlight->redirectRoute('positions.edit', $position);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new Department());
    }
}
