<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class StoryTimeline extends Component
{
    public string $sort = 'oldest';

    public function getStoriesProperty(): Collection
    {
        return Story::tree()
            ->withCount('posts', 'recursivePosts')
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
