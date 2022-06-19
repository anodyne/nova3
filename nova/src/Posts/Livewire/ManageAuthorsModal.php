<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use LivewireUI\Modal\ModalComponent;
use Nova\Characters\Models\Character;
use Nova\PostTypes\Models\PostType;

class ManageAuthorsModal extends ModalComponent
{
    public PostType $postType;

    public array $selectedCharacters = [];

    public array $selectedCharactersDisplay = [];

    public array $selectedUsers = [];

    protected $listeners = [
        'selectedCharacterAuthors',
        'selectedUserAuthors',
    ];

    public function apply(): void
    {
        $this->closeModalWithEvents([
            'posts:step:write-post' => ['authorsSelected', [
                $this->selectedCharacters,
                $this->selectedUsers,
            ]],
        ]);
    }

    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function selectedCharacterAuthors(array $authors): void
    {
        $characters = Character::query()
            ->whereIn('id', $authors)
            ->get();

        $this->selectedCharacters += $characters->mapWithKeys(fn (Character $character) => [
                $character->id => [
                    'user_id' => $character->activeUsers()->count() === 1
                        ? $character->activeUsers()->first()->id
                        : null
                ]
            ])
            ->all();

        $this->selectedCharactersDisplay += $characters->mapWithKeys(fn (Character $character) => [
                $character->id => [
                    'character' => $character->append('avatar_url'),
                    'user' => $character->activeUsers()->count() === 1
                        ? $character->activeUsers()->first()->name
                        : null,
                ]
            ])
            ->all();
    }

    public function selectedUserAuthors(array $authors): void
    {
        collect($authors)
            ->each(fn ($author) => $this->selectedUsers[$author] = [
                'user_id' => $author,
                'as' => null,
            ]);
    }

    public function render()
    {
        return view('livewire.posts.manage-authors-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }
}
