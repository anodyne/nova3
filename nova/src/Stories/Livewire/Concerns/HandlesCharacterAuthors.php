<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

trait HandlesCharacterAuthors
{
    public Collection $characters;

    public array $selectedCharacters = [];

    public array $validateSelectedCharacters = [];

    public function mountHandlesCharacterAuthors()
    {
        $this->setCharacterPivotData();
    }

    public function addCharacterAuthor(Character $character): void
    {
        $this->search = '';

        $this->characters->push($character);

        $numberOfActiveUsers = $character->activeUsers()->count();

        $this->selectedCharacters[$character->id] = [
            'user_id' => $numberOfActiveUsers === 1 ? $character->activeUsers->first()->id : null,
        ];

        if ($numberOfActiveUsers > 1) {
            $this->validateSelectedCharacters[$character->id] = $character->id;
        }
    }

    public function removeCharacterAuthor(Character $character): void
    {
        $this->dispatch('dropdown-close');

        $this->characters = $this->characters->reject(
            fn (Character $collectionCharacter) => $collectionCharacter->id === $character->id
        );

        unset($this->selectedCharacters[$character->id]);
        unset($this->validateSelectedCharacters[$character->id]);
    }

    public function setCharacterPivotData(): void
    {
        $this->selectedCharacters = $this->post?->characterAuthors
            ->mapWithKeys(
                fn (Character $character) => [
                    $character->id => [
                        'user_id' => $character->pivot->user_id,
                    ],
                ]
            )
            ->all() ?? [];
    }

    #[Computed]
    public function allUsers(): Collection
    {
        return User::active()->get();
    }

    #[Computed]
    public function filteredCharacters(): Collection
    {
        if ($this->postType?->options?->allowsCharacterAuthors) {
            return Character::query()
                ->active()
                ->whereNotIn('id', array_keys($this->selectedCharacters))
                ->when(filled($this->search), fn (Builder $query): Builder => $query->searchForBasic($this->search))
                ->get();
        }

        return Collection::make();
    }
}
