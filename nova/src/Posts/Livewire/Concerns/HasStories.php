<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Nova\Stories\Models\Story;

trait HasStories
{
    public mixed $storyId = null;

    public mixed $story = null;

    public function mountHasStories(): void
    {
        $data = Arr::get(
            $this->state()->forStep('posts:step:setup-post'),
            'storyId'
        );

        $this->story = $this->allStories->where('id', $data)->first();

        $this->storyId = $data;

        if ($this->story === null) {
            $this->setStory($this->allStories->first());
        }
    }

    public function getAllStoriesProperty(): Collection
    {
        return Story::whereCurrent()->get();
    }

    public function setStory(?Story $story): void
    {
        $this->storyId = $story?->id;
        $this->story = $story;

        $this->post->update(['story_id' => $this->storyId]);
    }
}
