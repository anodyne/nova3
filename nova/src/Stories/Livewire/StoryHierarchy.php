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

    public $parent;

    public $parentId;

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
        $parentId = 1,
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
        $this->parentStories = Story::defaultOrder()->get();

        $this->getOrderStories();

        if ($this->story !== null) {
            $nextNeighbor = $this->story->getNextSibling();
            $previousNeighbor = ($nextNeighbor === null)
                ? $this->story->getPrevSibling()
                : null;

            $this->neighbor = optional($nextNeighbor)->id ?? optional($previousNeighbor)->id;
            $this->direction = $nextNeighbor ? 'before' : 'after';
        }

        if ($this->parentId > 1) {
            $this->parent = $this->getStory($this->parentId);
        }

        if ($this->neighbor === null) {
            $this->neighbor = optional($this->orderStories->last())->id;
        } else {
            $this->parentId = optional($this->getStory($this->neighbor))->parent_id;
        }

        $this->getOrderStories();
    }

    public function render()
    {
        return view('livewire.stories.hierarchy');
    }

    protected function getOrderStories(): void
    {
        $this->orderStories = Story::whereParent($this->parentId)
            ->defaultOrder()
            ->get();
    }

    protected function getStory($id): Story
    {
        return Story::find($id);
    }
}
