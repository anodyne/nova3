<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Illuminate\Support\Collection;
use Nova\Stories\Models\Story;

trait HasStory
{
    public ?int $storyId = null;

    public mixed $story = null;

    public function mountHasStory(): void
    {
        $data = data_get(
            $this->state()->forStep('posts:step:setup-post'),
            'storyId'
        );

        $this->story = $this->currentStories->where('id', $data)->first();

        $this->storyId = $data;

        if ($this->story === null) {
            $this->setStory($this->currentStories->first());
        }
    }

    public function getCurrentStoriesProperty(): Collection
    {
        return Story::current()->get();
    }

    public function setStory(?Story $story): void
    {
        $this->storyId = $story?->id;
        $this->story = $story;

        $this->post->update(['story_id' => $this->storyId]);
    }

    public function updatedStoryId($value): void
    {
        $this->setStory($this->currentStories->where('id', $value)->first());
    }
}
