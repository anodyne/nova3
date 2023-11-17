<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use Nova\Posts\Livewire\Steps\PublishPostStep;
use Nova\Posts\Models\Post;

class SelectPostPositionModal extends ModalComponent
{
    public int $story = 0;

    public string $search = '';

    public ?int $selected;

    public string $direction = 'after';

    public function apply(): void
    {
        $this->closeModalWithEvents([
            PublishPostStep::class => ['selectedNewPostPosition', [$this->selected, $this->direction]],
        ]);
    }

    /**
     * Dismiss the modal.
     */
    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function afterPost(): void
    {
        $this->direction = 'after';
    }

    public function beforePost(): void
    {
        $this->direction = 'before';
    }

    public function selectPost(Post $post): void
    {
        $this->selected = $post->id;
    }

    public function getFilteredPostsProperty(): Collection
    {
        return Post::query()
            ->story($this->story)
            ->published()
            ->when($this->search, fn ($query, $search) => $query->searchFor($search))
            ->ordered()
            ->get();
    }

    public function mount($story)
    {
        $this->story = $story;
    }

    public function render()
    {
        return view('pages.posts.livewire.select-post-position-modal', [
            'posts' => $this->filteredPosts,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
