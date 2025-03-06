<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Nova\Characters\Models\Character;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Stories\Livewire\Concerns\HandlesCharacterAuthors;
use Nova\Stories\Livewire\Concerns\HandlesUserAuthors;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Stories\Models\PostType;
use Nova\Stories\Notifications\CharacterAuthorAddedToPost;
use Nova\Stories\Notifications\CharacterAuthorRemovedFromPost;
use Nova\Stories\Notifications\UserAuthorAddedToPost;
use Nova\Stories\Notifications\UserAuthorRemovedFromPost;

class ManagePostAuthors extends SlideOver
{
    use HandlesCharacterAuthors;
    use HandlesUserAuthors;

    public int|Post $post;

    public string $search = '';

    #[Computed]
    public function canAddAuthors(): bool
    {
        if ($this->postType?->options?->allowsMultipleAuthors) {
            return true;
        }

        if ($this->characters->count() > 0 || $this->users->count() > 0) {
            return false;
        }

        return true;
    }

    #[Computed]
    public function authorSearchPlaceholder(): string
    {
        $options = $this->postType?->options;

        return match (true) {
            $options?->allowsCharacterAuthors && ! $options?->allowsUserAuthors => 'Find a character to add as an author',
            ! $options?->allowsCharacterAuthors && $options?->allowsUserAuthors => 'Find a user to add as an author',
            default => 'Find a character or user to add as an author',
        };
    }

    #[Computed]
    public function postType(): PostType
    {
        return $this->post->postType;
    }

    // public function updated($property, $value)
    // {
    //     $propertyStr = str($property);

    //     if ($propertyStr->startsWith('selectedCharacters')) {
    //         [, $characterId] = explode('.', $property);

    //         if (filled($value)) {
    //             unset($this->validateSelectedCharacters[$characterId]);
    //         } else {
    //             $this->validateSelectedCharacters[$characterId] = $characterId;
    //         }
    //     }
    // }

    public function save(): void
    {
        $this->close(
            andDispatch: [
                'characterAuthorsChanged' => [$this->characterAuthorPivotData],
                'userAuthorsUpdated' => [$this->selectedUsers],
            ]
        );
    }

    public function mount(int $postId, $incomingCharacters, $incomingUsers)
    {
        $this->post = Post::findOrFail($postId);

        dd($incomingCharacters);

        $this->characterAuthors = Character::whereIn('id', collect($incomingCharacters)->pluck('id'))->get();
        $this->characterAuthorPivotData = collect($incomingCharacters)->toArray();

        $this->syncCharacterAuthorPivotData($postId);

        $this->handleUserAuthorsUpdated($incomingUsers);
    }

    public function render()
    {
        return view('pages.posts.livewire.manage-post-authors', [
            'authorSearchPlaceholder' => $this->authorSearchPlaceholder,
            'canAddAuthors' => $this->canAddAuthors,
            'filteredCharacters' => $this->filteredCharacters,
            'filteredUsers' => $this->filteredUsers,
        ]);
    }

    public static function size(): string
    {
        return '3xl';
    }

    protected function sendNotificationsToAddedAuthors(Collection $original, Collection $new): void
    {
        $new->diff($original)->each(
            fn (PostAuthor $participant) => match ($participant->authorable_type) {
                'character' => $participant->user->notify(
                    new CharacterAuthorAddedToPost($this->post, $participant->character)
                ),

                'user' => $participant->user->notify(new UserAuthorAddedToPost($this->post)),

                default => null,
            }
        );
    }

    protected function sendNotificationsToRemovedAuthors(Collection $original, Collection $new): void
    {
        $original->diff($new)->each(
            fn (PostAuthor $participant) => match ($participant->authorable_type) {
                'character' => $participant->user->notify(
                    new CharacterAuthorRemovedFromPost($this->post, $participant->character)
                ),

                'user' => $participant->user->notify(new UserAuthorRemovedFromPost($this->post)),

                default => null,
            }
        );
    }
}
