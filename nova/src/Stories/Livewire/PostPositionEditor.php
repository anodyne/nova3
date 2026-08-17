<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Stories\Enums\PositionDirection;
use Nova\Stories\Livewire\Concerns\InteractsWithPost;
use Nova\Stories\Models\Post;

/**
 * @property-read Collection $searchResults
 */
class PostPositionEditor extends SlideOver
{
    use InteractsWithPost;

    public string $search = '';

    public ?int $previousPostId = null;

    public ?int $nextPostId = null;

    public Post $currentPost;

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

    public function save(): void
    {
        $this->close(andDispatch: [
            'update-post-position' => [$this->neighbor->id, $this->direction],
        ]);
    }

    public function updatedDirection($value)
    {
        if (in_array($this->direction, [PositionDirection::End, PositionDirection::Start])) {
            $this->neighbor = null;
        }
    }

    public function mount(int $postId, ?int $previousId, ?int $nextId): void
    {
        $this->postId = $postId;
        $this->previousPostId = $previousId;
        $this->nextPostId = $nextId;

        $this->direction = PositionDirection::After;
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-position-editor', [
            'searchResults' => $this->searchResults,
        ]);
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

    public static function size(): string
    {
        return 'xl';
    }
}
