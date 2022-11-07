<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Livewire\Component;
use Nova\Stories\Filters\StoryFilters;
use Nova\Stories\Models\Story;

class StoryTimeline extends Component
{
    public $selectedStory;

    public function selectStory(Story $story): void
    {
        $this->selectedStory = $story;
    }

    public function getStoriesProperty(StoryFilters $filters)
    {
        return Story::query()
            ->hasParent()
            ->defaultOrder()
            ->filter($filters)
            ->get()
            ->toTree();
    }

    public function render()
    {
        return view('livewire.stories.timeline', [
            'storyClass' => Story::class,
            'storyCount' => Story::withDepth()->having('depth', '=', 1)->count(),
        ]);
    }
}
