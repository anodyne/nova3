<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Actions\Action;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Renderless;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Stories\Actions\UnlockPost;
use Nova\Stories\Actions\UpdatePostPosition;
use Nova\Stories\Actions\UpdatePostStatus;
use Nova\Stories\Data\PostPositionData;
use Nova\Stories\Data\PostStatusData;
use Nova\Stories\Enums\PositionDirection;
use Nova\Stories\Livewire\Concerns\InteractsWithPost;
use Nova\Stories\Livewire\Concerns\InteractsWithPostType;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Published;

class PostPublish extends SlideOver
{
    use InteractsWithPost;
    use InteractsWithPostType;

    #[Locked]
    public Post $post;

    public ?Collection $participatingUsers = null;

    public string $search = '';

    public ?Post $previousPost = null;

    public ?Post $nextPost = null;

    public ?Post $neighbor = null;

    public PositionDirection $direction;

    public function add(int $postId): void
    {
        $this->search = '';

        $this->neighbor = Post::query()
            ->select(['id', 'story_id', 'post_type_id', 'title', 'location', 'day', 'time'])
            ->find($postId);
    }

    public function updatedDirection($value)
    {
        if (in_array($this->direction, [PositionDirection::End, PositionDirection::Start])) {
            $this->neighbor = null;
        }
    }

    #[Renderless]
    public function dismiss(): void
    {
        Notification::make()->warning()
            ->title('Refresh to see updated post details')
            ->body('Post details may have been updated. You should refresh the page to ensure you are viewing the latest post information.')
            ->actions([
                Action::make('refresh')
                    ->color('gray')
                    ->icon(Tabler::Reload)
                    ->url(route('admin.posts.edit', $this->post)),
            ])
            ->send();

        $this->dispatch('modal-close');
    }

    public function publish(): void
    {
        $this->updatePostPosition();

        UnlockPost::run($this->post, Auth::user());

        $this->post->save();

        $post = UpdatePostStatus::run($this->post, PostStatusData::from('published'));

        if ($post->status->equals(Published::class)) {
            Notification::make()->success()
                ->title('Post has been published')
                ->send();
        } else {
            Notification::make()->warning()
                ->title('Post has been sent for approval')
                ->body('One or more authors have been marked for post moderation. This post will require approval before being published.')
                ->send();
        }

        $this->redirectRoute('admin.writing-overview');
    }

    public function refreshParticipatingUsers(): void
    {
        $this->participatingUsers = $this->post->fresh()->participatingUsers;
    }

    public function removeAllNonParticipants(): void
    {
        $this->dispatch('dropdown-close');

        $this->post->removeAllNonParticipants();

        $this->refreshParticipatingUsers();
    }

    public function removeParticipant(int $userId): void
    {
        $this->dispatch('dropdown-close');

        $this->post->removeParticipant($userId);

        $this->refreshParticipatingUsers();
    }

    public function updatePostPosition(): void
    {
        $positionChange = match (true) {
            filled($this->neighbor) && in_array($this->direction, [PositionDirection::After, PositionDirection::Before]) => true,
            blank($this->neighbor) && in_array($this->direction, [PositionDirection::End, PositionDirection::Start]) => true,
            default => false,
        };

        UpdatePostPosition::run($this->post, PostPositionData::from(
            neighbor: $this->neighbor,
            direction: $this->direction,
            hasPositionChange: $positionChange
        ));
    }

    public function hydrate(): void
    {
        $this->setPostAttributes();
    }

    public function mount(int $postId): void
    {
        $this->postId = $postId;

        $this->direction = PositionDirection::After;

        $this->setPostAttributes();
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-publish', [
            'hasNonParticipants' => $this->hasNonParticipants,
            'searchResults' => $this->searchResults,
            'shouldShowParticipantsPanel' => $this->shouldShowParticipantsPanel,
            'shouldShowPositionPanel' => $this->shouldShowPositionPanel,
        ]);
    }

    #[Computed]
    public function hasNonParticipants(): bool
    {
        return $this->post->participatingUsers()
            ->newPivotStatement()
            ->where('post_id', $this->post->id)
            ->whereNotIn('user_id', $this->post->participants ?? [])
            ->count() > 0;
    }

    #[Computed]
    public function searchResults(): Collection
    {
        return Post::query()
            ->select(['id', 'story_id', 'post_type_id', 'title', 'location', 'day', 'time'])
            ->story($this->getPost()?->story_id)
            ->when(filled($this->search), fn (Builder $query): Builder => $query->searchFor($this->search))
            ->ordered()
            ->get();
    }

    #[Computed]
    public function shouldShowParticipantsPanel(): bool
    {
        return ($this->post->characterAuthors()->count() + $this->post->userAuthors()->count()) > 1;
    }

    #[Computed]
    public function shouldShowPositionPanel(): bool
    {
        return $this->post->story->posts()->count() > 0;
    }

    public static function size(): string
    {
        return 'xl';
    }

    private function setPostAttributes(): void
    {
        $this->post = $this->getPost();
        $this->postTypeId = $this->post->post_type_id;

        $this->participatingUsers = $this->post->participatingUsers;

        $this->previousPost = $this->post->previousSibling(Published::class);
        $this->nextPost = $this->post->nextSibling(Published::class);
    }
}
