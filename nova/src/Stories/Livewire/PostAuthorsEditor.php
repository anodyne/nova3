<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Nova\Characters\Models\Character;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Users\Models\User;

#[On('post-authors-modified')]
class PostAuthorsEditor extends SlideOver
{
    use Concerns\InteractsWithCharacterAuthors;
    use Concerns\InteractsWithPost;
    use Concerns\InteractsWithPostType;
    use Concerns\InteractsWithUserAuthors;

    public string $search = '';

    public function canSave(): bool
    {
        return count($this->characterAuthorsValidationErrors) === 0;
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

    #[Computed]
    public function allUsers(): Collection
    {
        return User::active()->get();
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
    public function canAddAuthors(): bool
    {
        if ($this->postType?->options?->allowsMultipleAuthors) {
            return true;
        }

        if ($this->characterAuthors()->count() > 0 || $this->userAuthors->count() > 0) {
            return false;
        }

        return true;
    }

    #[Computed]
    public function filteredCharacters(): Collection
    {
        if (! $this->postType?->options?->allowsCharacterAuthors) {
            return Collection::make();
        }

        return Character::query()
            ->active()
            ->whereNotIn('id', array_keys($this->characterAuthorsPivotData))
            ->when(filled($this->search), fn (Builder $query): Builder => $query->searchForWithoutUsers($this->search))
            ->get();
    }

    #[Computed]
    public function filteredUsers(): Collection
    {
        if (! $this->postType?->options?->allowsUserAuthors) {
            return Collection::make();
        }

        return User::query()
            ->active()
            ->whereNotIn('id', array_keys($this->userAuthorsPivotData))
            ->when(filled($this->search), fn (Builder $query): Builder => $query->searchForWithoutCharacters($this->search))
            ->get();
    }

    public static function size(): string
    {
        return '3xl';
    }
}
