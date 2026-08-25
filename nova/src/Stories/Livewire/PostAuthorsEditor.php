<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Nova\Characters\Models\Character;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Stories\Livewire\Concerns\InteractsWithCharacterAuthors;
use Nova\Stories\Livewire\Concerns\InteractsWithPost;
use Nova\Stories\Livewire\Concerns\InteractsWithPostType;
use Nova\Stories\Livewire\Concerns\InteractsWithUserAuthors;
use Nova\Stories\Models\PostType;
use Nova\Users\Models\User;

/**
 * @property-read Collection<int, User> $allUsers
 * @property-read string $authorSearchPlaceholder
 * @property-read bool $canAddAuthors
 * @property-read Collection<int, Character> $filteredCharacters
 * @property-read Collection<int, User> $filteredUsers
 * @property-read Collection<int, PostType> $availablePostTypes
 * @property-read ?PostType $postType
 *
 * @phpstan-import-type CharacterAuthor from InteractsWithCharacterAuthors
 * @phpstan-import-type UserAuthor from InteractsWithUserAuthors
 */
#[On('post-authors-modified')]
class PostAuthorsEditor extends SlideOver
{
    use InteractsWithCharacterAuthors;
    use InteractsWithPost;
    use InteractsWithPostType;
    use InteractsWithUserAuthors;

    public ?string $selected = null;

    /** @return Collection<int, User> */
    #[Computed]
    public function allUsers(): Collection
    {
        return User::active()->get();
    }

    #[Computed]
    public function authorSearchPlaceholder(): string
    {
        $options = $this->postType?->options;

        if ($options === null) {
            return 'Find a character or user to add as an author';
        }

        return match (true) {
            $options->allowsCharacterAuthors && ! $options->allowsUserAuthors => 'Find a character to add as an author',
            ! $options->allowsCharacterAuthors && $options->allowsUserAuthors => 'Find a user to add as an author',
            default => 'Find a character or user to add as an author',
        };
    }

    #[Computed]
    public function canAddAuthors(): bool
    {
        if ($this->postType?->options?->allowsMultipleAuthors) {
            return true;
        }

        return $this->characterAuthors()->count() <= 0 && $this->userAuthors()->count() <= 0;
    }

    public function canSave(): bool
    {
        return count($this->characterAuthorsValidationErrors) === 0;
    }

    /** @return Collection<int, Character> */
    #[Computed]
    public function filteredCharacters(): Collection
    {
        if (! $this->postType?->options?->allowsCharacterAuthors) {
            return Collection::make();
        }

        return Character::query()
            ->active()
            ->whereNotIn('id', array_keys($this->characterAuthorsPivotData))
            ->get();
    }

    /** @return Collection<int, User> */
    #[Computed]
    public function filteredUsers(): Collection
    {
        if (! $this->postType?->options?->allowsUserAuthors) {
            return Collection::make();
        }

        return User::query()
            ->active()
            ->whereNotIn('id', array_keys($this->userAuthorsPivotData))
            // ->when(filled($this->search), fn (Builder $query): Builder => $query->searchForWithoutCharacters($this->search))
            ->get();
    }

    /**
     * @param  array<int, CharacterAuthor>  $characterAuthors
     * @param  array<int, UserAuthor>  $userAuthors
     */
    public function mount(array $characterAuthors, array $userAuthors): void
    {
        $this->setCharacterAuthors($characterAuthors);
        $this->setUserAuthors($userAuthors);
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-authors-editor', [
            'allUsers' => $this->allUsers,
            'authorSearchPlaceholder' => $this->authorSearchPlaceholder,
            'canAddAuthors' => $this->canAddAuthors,
            'canSave' => $this->canSave(),
            'filteredCharacters' => $this->filteredCharacters,
            'filteredUsers' => $this->filteredUsers,
            'characterAuthors' => $this->characterAuthors(),
            'postType' => $this->postType,
            'userAuthors' => $this->userAuthors(),
        ]);
    }

    public function save(): void
    {
        if ($this->canSave()) {
            $this->close(andDispatch: [
                'update-post-authors' => [
                    $this->characterAuthorsArr,
                    $this->characterAuthorsPivotData,
                    $this->userAuthorsArr,
                    $this->userAuthorsPivotData,
                ],
            ]);
        }
    }

    public static function size(): string
    {
        return '3xl';
    }
}
