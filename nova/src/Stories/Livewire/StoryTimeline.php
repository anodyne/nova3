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
            ->whereNull('parent_id')
            ->orderBy('sort')
            ->filter($filters)
            ->get();
    }

    public function render()
    {
        return view('livewire.stories.timeline', [
            'storyClass' => Story::class,
            // 'storyCount' => Story::withDepth()->having('depth', '=', 1)->count(),
            'storyCount' => 1,
        ]);
    }
}
