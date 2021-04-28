<?php

namespace Nova\Characters\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Characters\Models\Character;

class EditCharacter extends SpotlightCommand
{
    protected string $name = 'Edit Character';

    protected string $description = 'Edit a character bio';

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('character')
                    ->setPlaceholder('Which character do you want to edit?')
            );
    }

    public function searchCharacter($query)
    {
        return Character::where('name', 'like', "%${query}%")
            ->get()
            ->map(function (Character $character) {
                return new SpotlightSearchResult(
                    $character->id,
                    $character->name,
                    sprintf('View %s', $character->name)
                );
            });
    }

    public function execute(Spotlight $spotlight, Character $character): void
    {
        $spotlight->redirectRoute('characters.edit', $character);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new Character);
    }
}
