<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Livewire\Component;
use Nova\Stories\Models\Story;

class StoryHierarchy extends Component
{
    public $direction;

    public $hasPositionChange = false;

    public $neighbor;

    public $orderStories;

    public ?Story $parent = null;

    public $parentId = null;

    public $parentStories;

    public $story;

    public function updatedDirection($value)
    {
        $this->hasPositionChange = true;
    }

    public function updatedParentId($value)
    {
        $this->hasPositionChange = true;

        $this->parent = Story::find($value);

        $this->getOrderStories();
    }

    public function updatedNeighbor($value)
    {
        $this->hasPositionChange = true;
    }

    public function mount(
        $parentId = null,
        $direction = 'after',
        $neighbor = null,
        $hasPositionChange = false,
        $story = null
    ) {
        $this->parentId = $parentId;
        $this->direction = $direction;
        $this->neighbor = $neighbor;
        $this->hasPositionChange = $hasPositionChange;
        $this->story = $story;
        $this->parentStories = Story::tree()->ordered()->get();

        $this->getOrderStories();

        if ($this->story !== null) {
            $nextNeighbor = $this->story->nextSibling();
            $previousNeighbor = ($nextNeighbor === null)
                ? $this->story->previousSibling()
                : null;

            $this->neighbor = $nextNeighbor?->id ?? $previousNeighbor?->id;
            $this->direction = $nextNeighbor ? 'before' : 'after';
        }

        if (filled($this->parentId)) {
            $this->parent = $this->getStory($this->parentId);
        }

        if ($this->neighbor === null) {
            $this->neighbor = $this->orderStories->last()?->id;
        } else {
            $this->parentId = $this->getStory($this->neighbor)?->parent_id;
        }

        $this->getOrderStories();
    }

    public function render()
    {
        return view('livewire.stories.hierarchy');
    }

    protected function getOrderStories(): void
    {
        $this->orderStories = Story::query()
            ->when(filled($this->parentId), fn ($query) => $query->parent($this->parentId))
            ->when(blank($this->parentId), fn ($query) => $query->isRoot())
            ->ordered()
            ->get();
    }

    protected function getStory($id): Story
    {
        return Story::find($id);
    }
}
