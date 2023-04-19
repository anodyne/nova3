<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Livewire\Component;
use Nova\Stories\Filters\StoryFilters;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class StoryTimeline extends Component
{
    public $selectedStory;

    public function selectStory(Story $story): void
    {
        $this->selectedStory = $story;
    }

    public function getStoriesProperty(StoryFilters $filters): Collection
    {
        return Story::tree()
            ->withCount('posts', 'recursivePosts')
            ->ordered()
            ->get()
            ->toTree();
    }

    public function render()
    {
        return view('livewire.stories.timeline', [
            'storyClass' => Story::class,
        ]);
    }
}
