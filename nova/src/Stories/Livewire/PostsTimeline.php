<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Builders\PostBuilder;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

/**
 * @property-read EloquentCollection<int, Post> $posts
 * @property-read Collection<int, Story> $stories
 * @property-read Collection<int, Story> $currentStories
 */
class PostsTimeline extends Component
{
    public bool $admin = true;

    /** @var 'asc'|'desc' */
    public string $sortDirection = 'desc';

    public string $sortField = 'order_column';

    public ?int $storyId = null;

    /**
     * @return Collection<int, Story>
     */
    #[Computed]
    public function currentStories(): Collection
    {
        return Story::query()->current()->get();
    }

    public function mount(): void
    {
        if ($this->currentStories->count() >= 1) {
            $this->storyId = $this->currentStories->first()->id;
        }
    }

    /**
     * @return EloquentCollection<int, Post>
     */
    #[Computed]
    public function posts(): EloquentCollection
    {
        if (blank($this->storyId)) {
            return EloquentCollection::make();
        }

        return Post::query()
            ->published()
            ->when(filled($this->storyId), fn (PostBuilder $query): PostBuilder => $query->forStory($this->storyId))
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
    }

    public function render(): \Illuminate\Contracts\View\View|Factory|View
    {
        $view = $this->admin
            ? 'pages.posts.livewire.timeline'
            : 'pages.public-site.livewire.posts-timeline';

        return view($view, [
            'stories' => $this->stories,
            'posts' => $this->posts,
            'postClass' => Post::class,
        ]);
    }

    /**
     * @return Collection<int, Story>
     */
    #[Computed]
    public function stories(): Collection
    {
        return Story::query()->get();
    }
}
