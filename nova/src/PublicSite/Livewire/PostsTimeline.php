<?php

declare(strict_types=1);

namespace Nova\PublicSite\Livewire;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

class PostsTimeline extends Component
{
    public ?Story $story = null;

    #[Computed]
    public function posts(): EloquentCollection
    {
        return Post::query()
            ->published()
            ->story($this->story?->id)
            ->whereHas('postType', fn ($query) => $query->inCharacter())
            ->orderBy('order_column', 'asc')
            ->get();
    }

    public function render()
    {
        return view('pages.public-site.livewire.posts-timeline', [
            'posts' => $this->posts,
        ]);
    }
}
