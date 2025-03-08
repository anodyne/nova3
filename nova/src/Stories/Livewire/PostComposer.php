<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Carbon\CarbonInterface;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Actions\DeletePost;
use Nova\Stories\Models\Post;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class PostComposer extends Component
{
    use Concerns\InteractsWithPostLocks;
    use Concerns\InteractsWithPostType;
    use Concerns\InteractsWithStories;
    use InteractsWithConfirmationModal;

    #[Locked]
    public Post $post;

    public ?CarbonInterface $lastUpdate = null;

    public int $savedChildrenCount = 0;

    public function delete(): void
    {
        $this->authorize('delete', $this->post);

        $this->askForConfirmation(
            callback: function () {
                DeletePost::run($this->post);

                Notification::make()->success()
                    ->title('Post was deleted')
                    ->send();

                $this->redirectRoute('admin.writing-overview');
            },
            prompt: [
                'title' => 'Delete post?',
                'message' => __('messages.delete-post'),
                'confirm' => 'Yes, delete',
                'cancel' => 'Cancel',
            ],
            confirmPhrase: 'DELETE',
            theme: 'danger',
        );
    }

    public function discard(): void
    {
        $this->authorize('discard', $this->post);

        $this->askForConfirmation(
            callback: function (): void {
                DeletePost::run($this->post);

                Notification::make()->success()
                    ->title($this->postType->name.' draft has been discarded')
                    ->send();

                $this->redirectRoute('admin.writing-overview');
            },
            prompt: [
                'title' => 'Discard draft?',
                'message' => __('messages.discard-post-draft', [
                    'type' => str($this->postType->name)->lower()->toString(),
                ]),
                'confirm' => 'Yes, discard',
                'cancel' => 'Cancel',
            ],
            confirmPhrase: 'DISCARD',
            theme: 'danger',
        );
    }

    public function handleUpdateFromChild(): void
    {
        $this->lastUpdate = now();
    }

    public function openForPublishing(): void
    {
        // $this->save();

        $this->dispatch(
            'slide-over.open',
            component: 'posts-publish',
            arguments: [
                'postId' => $this->post->id,
                'postTypeId' => $this->post->post_type_id,
            ]
        );
    }

    public function save(): void
    {
        $this->savedChildrenCount = 0;

        foreach ($this->childrenComponents() as $component) {
            $this->dispatch('save-post')->to($component);
        }

        $this->lastUpdate = null;
    }

    public function mount(?Post $post = null): void
    {
        $this->post = $post->loadMissing([
            'characterAuthors.activeUsers',
            'participatingUsers',
            'postType',
            'story',
            'userAuthors',
        ]);

        $this->postTypeId = $post->post_type_id;
        $this->storyId = $post->story_id;

        $this->lockPost();
    }

    public function render(): View
    {
        if ($this->postIsLocked) {
            return view('pages.posts.livewire.post-locked');
        }

        return view('pages.posts.livewire.post-composer', [
            'availablePostTypes' => $this->availablePostTypes,
            'currentStories' => $this->currentStories,
            'postIsDirty' => $this->isDirty,
            'postType' => $this->getPostType(),
            'story' => $this->getStory(),
        ]);
    }

    #[Computed]
    public function isDirty(): bool
    {
        return $this->lastUpdate !== null;
    }

    #[On('save-post-completed')]
    #[Renderless]
    public function checkAllSaved(): void
    {
        $this->savedChildrenCount++;

        $totalChildren = count($this->childrenComponents());

        if ($this->savedChildrenCount === $totalChildren) {
            Notification::make()->success()
                ->title('Post saved')
                ->send();

            $this->savedChildrenCount = 0;
        }
    }

    private function childrenComponents(): array
    {
        $components = [
            PostDetails::class,
            PostAuthors::class,
        ];

        if ($this->post?->postType?->fields?->rating?->enabled) {
            $components[] = PostRatings::class;
        }

        if ($this->post?->postType?->fields?->summary?->enabled) {
            $components[] = PostSummary::class;
        }

        $components[] = PostPosition::class;

        return $components;
    }
}
