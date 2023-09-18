<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class StoriesTimeline extends Component
{
    public string $sort = 'latest';

    public function getStoriesProperty(): Collection
    {
        return Story::tree()
            ->withCount('posts', 'recursivePosts', 'children')
            ->withSum('posts', 'word_count')
            ->when($this->sort === 'oldest', fn (Builder $query) => $query->ordered())
            ->when($this->sort === 'latest', fn (Builder $query) => $query->ordered('desc'))
            ->get()
            ->toTree();
    }

    public function render()
    {
        return view('livewire.stories.timeline', [
            'stories' => $this->stories,
            'storyClass' => Story::class,
        ]);
    }
}
