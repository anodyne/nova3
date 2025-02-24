<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Nova\Foundation\Livewire\Modal;
use Nova\Stories\Livewire\Steps\PublishPostStep;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

class SelectPostPositionModal extends Modal
{
    #[Locked]
    public int|Story $story;

    public string $search = '';

    public ?int $selected;

    public string $direction = 'after';

    public function apply(): void
    {
        $this->close(
            andDispatch: [
                PublishPostStep::class => ['selectedNewPostPosition', [$this->selected, $this->direction]],
            ]
        );
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

    public function mount(Story $story)
    {
        $this->story = $story;
    }

    public function render()
    {
        return view('pages.posts.livewire.select-post-position-modal', [
            'posts' => $this->filteredPosts,
        ]);
    }
}
