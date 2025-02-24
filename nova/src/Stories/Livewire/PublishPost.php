<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Features\SupportRedirects\Redirector;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Stories\Actions\SetPostPosition;
use Nova\Stories\Data\PostPositionData;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class PublishPost extends SlideOver
{
    public int|Post $post;

    #[Computed]
    public function previousPost(): ?Post
    {
        return $this->post->previousSibling(Published::class);
    }

    #[Computed]
    public function nextPost(): ?Post
    {
        return $this->post->nextSibling(Published::class);
    }

    #[Computed]
    public function numberOfPublishedPosts(): int
    {
        return $this->story->posts()->count();
    }

    #[Computed]
    public function story(): Story
    {
        return $this->post->story;
    }

    #[Computed]
    public function shouldShowPositionPanel(): bool
    {
        return $this->story->posts()->count() > 0;
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

    #[On('selectedNewPostPosition')]
    public function setNewPostPosition(...$args): void
    {
        [$neighbor, $direction] = $args;

        $this->setDirectionAndNeighbor($direction, $neighbor);

        SetPostPosition::run($this->post, PostPositionData::from(
            direction: $direction,
            neighbor: $neighbor,
            hasPositionChange: true,
        ));
    }

    public function publish(): Redirector
    {
        $this->form->save();

        if (! $this->post->is_published) {
            $this->post->status->transitionTo(Published::class);
        }

        return to_route('admin.writing-overview')
            ->notify($this->post->title.' has been published');
    }

    public function removeParticipant(User $user): void
    {
        $this->dispatch('dropdown-close');

        $this->post->removeParticipant($user);

        $this->refreshParticipatingUsers();
    }

    public function removeAllNonParticipants(): void
    {
        $this->dispatch('dropdown-close');

        $this->post->removeAllNonParticipants();

        $this->refreshParticipatingUsers();
    }

    public function refreshParticipatingUsers(): void
    {
        $this->post = $this->post->refresh();
    }

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('pages.posts.livewire.publish-post', [
            // 'shouldShowPositionPanel' => $this->shouldShowPositionPanel,
            // 'shouldShowParticipantsPanel' => $this->shouldShowParticipantsPanel,
            // 'hasNonParticipants' => $this->hasNonParticipants,
            // 'previousPost' => $this->previousPost,
            // 'nextPost' => $this->nextPost,
        ]);
    }

    public static function size(): string
    {
        return 'xl';
    }
}
