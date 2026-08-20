<?php

declare(strict_types=1);

namespace Nova\PublicSite\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Stories\Models\Builders\PostTypeBuilder;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

/**
 * @property-read Collection $posts
 */
class PostsTimeline extends Component
{
    #[Locked]
    public ?Story $story = null;

    #[Computed]
    public function posts(): EloquentCollection
    {
        return Post::query()
            ->published()
            ->forStory($this->story?->id)
            ->whereHas('postType', function (Builder $query): void {
                /** @var PostTypeBuilder $postTypeQuery */
                $postTypeQuery = $query;

                $postTypeQuery->inCharacter();
            })
            ->orderBy('order_column', 'asc')
            ->get();
    }

    public function render(): Factory|View
    {
        return view('pages.public-site.livewire.posts-timeline', [
            'posts' => $this->posts,
        ]);
    }
}
