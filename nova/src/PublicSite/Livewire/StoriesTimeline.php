<?php

declare(strict_types=1);

namespace Nova\PublicSite\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class StoriesTimeline extends Component
{
    public string $sortDirection = 'asc';

    #[Computed]
    public function stories(): Collection
    {
        return Story::tree()
            ->withCount('posts', 'recursivePosts', 'children')
            ->withSum(['recursivePosts', 'posts'], 'word_count')
            ->exceptUpcoming()
            ->orderBy('order_column', $this->sortDirection)
            ->get()
            ->toTree();
    }

    public function render()
    {
        return view('pages.public-site.livewire.stories-timeline', [
            'stories' => $this->stories,
        ]);
    }
}
