<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class StoriesTimeline extends Component
{
    public string $sortField = 'order_column';

    public string $sortDirection = 'desc';

    #[Computed]
    public function stories(): Collection
    {
        return Story::tree()
            ->withCount('posts', 'recursivePosts', 'children')
            ->withSum(['recursivePosts', 'posts'], 'word_count')
            ->orderBy($this->sortField, $this->sortDirection)
            ->get()
            ->toTree();
    }

    public function render()
    {
        return view('pages.stories.livewire.timeline', [
            'stories' => $this->stories,
            'storyClass' => Story::class,
        ]);
    }
}
