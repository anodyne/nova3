<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Illuminate\Support\Collection;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

trait HandlesCharacterAuthors
{
    public ?array $selectedCharacters;

    public function mountHandlesCharacterAuthors()
    {
        $this->setCharacterPivotData();
    }

    public function selectedCharacterAuthors(array $authors): void
    {
        $characters = Character::with('activeUsers')
            ->whereIn('id', $authors)
            ->whereNotIn('id', $this->post->characterAuthors->fresh()->map(fn ($author) => $author->id)->all())
            ->get()
            ->mapWithKeys(fn (Character $character) => [
                $character->id => [
                    'user_id' => $character->activeUsers()->count() === 1
                        ? $character->activeUsers()->first()->id
                        : null
                ]
            ])
            ->all();

        $this->post->characterAuthors()->attach($characters);

        $this->refreshCharacterAuthors();

        $this->setCharacterPivotData();
    }

    public function setCharacterPivotData(): void
    {
        $this->selectedCharacters = $this->post
            ->characterAuthors
            ->mapWithKeys(
                fn (Character $character) => [
                    $character->id => [
                        'user_id' => $character->pivot->user_id,
                    ]
                ]
            )
            ->all();
    }

    public function updatedSelectedCharacters(): void
    {
        $this->post->characterAuthors()->sync($this->selectedCharacters);
    }

    public function removeCharacterAuthor(Character $character): void
    {
        $this->post->characterAuthors()->detach($character->id);

        $this->refreshCharacterAuthors();
    }

    public function getAllUsersProperty(): Collection
    {
        return User::whereActive()->get();
    }

    protected function refreshCharacterAuthors(): void
    {
        $this->characters = $this->post->refresh()->characterAuthors;
    }
}
