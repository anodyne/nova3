<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class PostsTimeline extends Component
{
    public string $sortField = 'order_column';

    public string $sortDirection = 'desc';

    public ?int $storyId = null;

    public bool $admin = true;

    #[Computed]
    public function posts(): EloquentCollection
    {
        if (blank($this->storyId)) {
            return EloquentCollection::make();
        }

        return Post::query()
            ->published()
            ->when(filled($this->storyId), fn (Builder $query): Builder => $query->story($this->storyId))
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
    }

    #[Computed]
    public function stories(): Collection
    {
        return Story::query()->get();
    }

    #[Computed]
    public function currentStories(): Collection
    {
        return Story::query()->current()->get();
    }

    public function mount()
    {
        if ($this->currentStories->count() >= 1) {
            $this->storyId = $this->currentStories->first()->id;
        }
    }

    public function render()
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
}
