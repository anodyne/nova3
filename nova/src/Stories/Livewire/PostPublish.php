<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Stories\Models\Post;

class PostPublish extends SlideOver
{
    use Concerns\InteractsWithPost;
    use Concerns\InteractsWithPostType;

    #[Locked]
    public Post $post;

    public ?Collection $participatingUsers = null;

    public function publish(): void
    {
        // Do the publish

        $this->close();
    }

    public function mount(int $postId, int $postTypeId): void
    {
        $this->postId = $postId;
        $this->postTypeId = $postTypeId;

        $this->post = $this->getPost();

        $this->participatingUsers = $this->post->participatingUsers;
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-publish', [
            'hasNonParticipants' => $this->hasNonParticipants,
            'shouldShowParticipantsPanel' => $this->shouldShowParticipantsPanel,
        ]);
    }

    #[Computed]
    public function shouldShowParticipantsPanel(): bool
    {
        return $this->post->characterAuthors()->count() + $this->post->userAuthors()->count() > 1;
    }

    #[Computed]
    public function hasNonParticipants(): bool
    {
        return $this->post->participatingUsers()
            ->newPivotStatement()
            ->where('post_id', $this->post->id)
            ->whereNotIn('user_id', $this->post->participants)
            ->count() > 0;
    }

    public static function size(): string
    {
        return 'xl';
    }

    public static function removeStateOnClose(): bool
    {
        return true;
    }
}
