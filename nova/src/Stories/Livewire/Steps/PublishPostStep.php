<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Steps;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Features\SupportRedirects\Redirector;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Actions\SetPostPosition;
use Nova\Stories\Data\PostPositionData;
use Nova\Stories\Livewire\Concerns\HasParentState;
use Nova\Stories\Livewire\PostForm;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Users\Models\User;

class PublishPostStep extends WizardStep
{
    use HasParentState;

    public ?Post $post = null;

    public PostForm $form;

    public ?Post $previousPost = null;

    public ?Post $nextPost = null;

    public ?Collection $participatingUsers = null;

    public function goToNextStep(): void {}

    public function save(): void
    {
        $this->form->save();

        Notification::make()
            ->success()
            ->title($this->post->title.' has been saved')
            ->send();
    }

    public function stepInfo(): array
    {
        return [
            'label' => 'Publish post',
        ];
    }

    #[On('selectedNewPostPosition')]
    public function setNewPostPosition(...$args): void
    {
        [$neighbor, $direction] = $args;

        $this->setDirectionAndNeighbor($direction, $neighbor);

        SetPostPosition::run($this->post, PostPositionData::from([
            'direction' => $direction,
            'neighbor' => $neighbor,
            'hasPositionChange' => true,
        ]));
    }

    #[Computed]
    public function numberOfPublishedPosts(): int
    {
        return $this->story->posts()->count();
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

    public function publish(): Redirector
    {
        $this->form->save();

        if (! $this->post->is_published) {
            $this->post->status->transitionTo(Published::class);
        }

        return redirect()->route('admin.writing-overview')
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
        $this->participatingUsers = $this->post->fresh()->participatingUsers;
    }

    public function mount(): void
    {
        $this->post = Post::findOrFail($this->postId);

        $this->form->setPost($this->post);

        $this->participatingUsers = $this->post->participatingUsers;

        $this->previousPost = $this->post->previousSibling(Published::class);
        $this->nextPost = $this->post->nextSibling(Published::class);
    }

    public function render()
    {
        return view('pages.posts.livewire.steps.publish-post', [
            'shouldShowPositionPanel' => $this->shouldShowPositionPanel,
            'shouldShowParticipantsPanel' => $this->shouldShowParticipantsPanel,
            'hasNonParticipants' => $this->hasNonParticipants,
        ]);
    }

    protected function setDirectionAndNeighbor(string $direction, int $neighbor): void
    {
        if ($direction === 'before') {
            $this->nextPost = Post::find($neighbor);
            $this->previousPost = $this->nextPost->previousSibling(Published::class);
        } else {
            $this->previousPost = Post::find($neighbor);
            $this->nextPost = $this->previousPost->nextSibling(Published::class);
        }
    }
}
