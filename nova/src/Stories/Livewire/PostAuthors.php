<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Actions\UpdatePostAuthors;
use Nova\Stories\Data\PostAuthorsData;
use Nova\Stories\Livewire\Concerns\InteractsWithCharacterAuthors;
use Nova\Stories\Livewire\Concerns\InteractsWithPost;
use Nova\Stories\Livewire\Concerns\InteractsWithPostType;
use Nova\Stories\Livewire\Concerns\InteractsWithUserAuthors;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

/**
 * @property-read Collection<int, PostType> $availablePostTypes
 * @property-read ?PostType $postType
 *
 * @phpstan-import-type CharacterAuthor from \Nova\Stories\Livewire\Concerns\InteractsWithCharacterAuthors
 * @phpstan-import-type CharacterAuthorPivotData from \Nova\Stories\Livewire\Concerns\InteractsWithCharacterAuthors
 * @phpstan-import-type UserAuthor from \Nova\Stories\Livewire\Concerns\InteractsWithUserAuthors
 * @phpstan-import-type UserAuthorPivotData from \Nova\Stories\Livewire\Concerns\InteractsWithUserAuthors
 */
class PostAuthors extends Component
{
    use InteractsWithCharacterAuthors;
    use InteractsWithPost;
    use InteractsWithPostType;
    use InteractsWithUserAuthors;

    public function hasAuthors(): bool
    {
        return count($this->characterAuthorsArr) > 0 || count($this->userAuthorsArr) > 0;
    }

    public function openForEditing(): void
    {
        $this->dispatch(
            'modal-open',
            modal: 'posts-authors-editor',
            props: [
                'postId' => $this->postId,
                'postTypeId' => $this->postTypeId,
                'characterAuthors' => $this->characterAuthorsArr,
                'userAuthors' => $this->userAuthorsArr,
            ]
        );
    }

    public function mount(Post $post): void
    {
        $this->postId = $post->id;
        $this->postTypeId = $post->post_type_id;

        $this->setCharacterAuthors($post->characterAuthors);
        $this->setUserAuthors($post->userAuthors);
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-authors', [
            'characterAuthors' => $this->characterAuthors(),
            'hasAuthors' => $this->hasAuthors(),
            'userAuthors' => $this->userAuthors(),
        ]);
    }

    #[On('save-post')]
    #[Renderless]
    public function save(): void
    {
        try {
            $post = $this->getPost();

            UpdatePostAuthors::run($post, PostAuthorsData::from(
                characters: $this->characterAuthorsPivotData,
                originalCharacters: $post->characterAuthors,
                users: $this->userAuthorsPivotData,
                originalUsers: $post->userAuthors
            ));

            $this->dispatch('save-post-completed')->to(PostComposer::class);
        } catch (ModelNotFoundException) {
            Notification::make()->danger()
                ->title('Post authors could not be saved')
                ->send();
        }
    }

    /**
     * @param  array<int, CharacterAuthor>  $characterAuthors
     * @param  array<int, CharacterAuthorPivotData>  $characterAuthorsPivotData
     * @param  array<int, UserAuthor>  $userAuthors
     * @param  array<int, UserAuthorPivotData>  $userAuthorsPivotData
     */
    #[On('update-post-authors')]
    public function handleAuthorUpdates(array $characterAuthors, array $characterAuthorsPivotData, array $userAuthors, array $userAuthorsPivotData): void
    {
        $this->setCharacterAuthors($characterAuthors);
        $this->characterAuthorsPivotData = $characterAuthorsPivotData;

        $this->setUserAuthors($userAuthors);
        $this->userAuthorsPivotData = $userAuthorsPivotData;

        $this->dispatch('post-updated');
    }
}
