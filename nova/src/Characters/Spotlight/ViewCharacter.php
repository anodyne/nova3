<?php

declare(strict_types=1);

namespace Nova\Characters\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Characters\Models\Character;

class ViewCharacter extends SpotlightCommand
{
    protected string $name = 'View Character';

    protected string $description = 'View a character bio';

    protected array $synonyms = [
        'show character',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('character')
                    ->setPlaceholder('Which character do you want to view?')
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
        $spotlight->redirectRoute('characters.show', $character);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Character::class);
    }
}
