<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Nova\Characters\Models\Character;
use Nova\Stories\Livewire\PostComposer;
use Nova\Stories\Models\PostAuthor;
use Nova\Users\Models\User;

trait HandlesCharacterAuthorsBackup
{
    public Collection $characters;

    public array $selectedCharacters = [];

    public array $validateSelectedCharacters = [];

    public function mountHandlesCharacterAuthors()
    {
        logger('mounting HandlesCharacterAuthors');

        $this->setCharacterPivotData();
    }

    public function hydrateHandlesCharacterAuthors()
    {
        logger('hydrating HandlesCharacterAuthors');

        dd($this->characters->toArray());

        $this->characters->loadMissing('activeUsers');
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

    #[On('characterAuthorsUpdated')]
    public function handleCharacterAuthorsUpdated($selectedCharacters): void
    {
        logger('handling character author updates');

        $this->selectedCharacters = $selectedCharacters;

        // Extract character IDs
        $characterIds = array_keys($selectedCharacters);

        // Retrieve characters and their PostAuthor pivot data
        $this->characters = Character::whereIn('id', $characterIds)
            ->with([
                'postAuthors' => function ($query) {
                    $query->where('authorable_type', 'character')
                        ->with('user'); // Ensure user relationship is loaded
                },
                'activeUsers',
            ])->get();

        // Attach pivot relations dynamically (without saving to DB)
        foreach ($this->characters as $character) {
            $pivot = new PostAuthor([
                'user_id' => $selectedCharacters[$character->id]['user_id'] ?? null,
            ]);

            // Retain existing user relationship in the pivot
            $pivot->setRelation('user', $character->postAuthors->first()?->user ?? null);

            $character->setRelation('pivot', $pivot);
        }

        if ($this instanceof PostComposer) {
            $this->updated('characters');
        }
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
