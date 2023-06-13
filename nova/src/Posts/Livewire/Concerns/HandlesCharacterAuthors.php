<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Illuminate\Support\Collection;
use Nova\Characters\Models\Character;
use Nova\Posts\Notifications\CharacterAuthorAddedToPost;
use Nova\Posts\Notifications\CharacterAuthorRemovedFromPost;
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
            ->get();

        $characterData = $characters->mapWithKeys(fn (Character $character) => [
            $character->id => [
                'user_id' => $character->activeUsers()->count() === 1
                    ? $character->activeUsers()->first()->id
                    : null,
            ],
        ])
            ->all();

        $this->post->characterAuthors()->attach($characterData);

        $this->refreshCharacterAuthors();

        $this->setCharacterPivotData();

        $this->sendNotificationsToAddedCharacters($characters);
    }

    public function setCharacterPivotData(): void
    {
        $this->selectedCharacters = $this->post
            ->characterAuthors
            ->mapWithKeys(
                fn (Character $character) => [
                    $character->id => [
                        'user_id' => $character->pivot->user_id,
                    ],
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
        $this->dispatchBrowserEvent('dropdown-close');

        $this->post->characterAuthors()->detach($character->id);

        $this->refreshCharacterAuthors();

        $userForNotification = $this->post->characterAuthors()
            ->wherePivot('authorable_type', 'character')
            ->wherePivot('authorable_id', $character->id)
            ->first();

        if ($userForNotification) {
            User::find($userForNotification->pivot->user_id)
                ->notify(new CharacterAuthorRemovedFromPost($this->post, $character));
        }
    }

    public function getAllUsersProperty(): Collection
    {
        return User::active()->get();
    }

    protected function refreshCharacterAuthors(): void
    {
        $this->characters = $this->post->refresh()->characterAuthors;
    }

    protected function sendNotificationsToAddedCharacters($characters): void
    {
        $users = [];

        foreach ($characters as $character) {
            foreach ($character->activeUsers as $user) {
                $users[$user->id][] = $character->displayName;
            }
        }

        foreach ($users as $userId => $characterNames) {
            if ($userId != auth()->id()) {
                User::find($userId)?->notify(new CharacterAuthorAddedToPost($this->post, $characterNames));
            }
        }
    }
}
