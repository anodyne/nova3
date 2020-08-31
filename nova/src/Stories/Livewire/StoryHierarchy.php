<?php

namespace Nova\Stories\Livewire;

use Livewire\Component;
use Nova\Stories\Models\Story;

class StoryHierarchy extends Component
{
    public $direction;

    public $hasPositionChange = false;

    public $neighbor;

    public $orderStories;

    public $parentId;

    public $parentStories;

    public function updatedDirection($value)
    {
        $this->hasPositionChange = true;
    }

    public function updatedParentId($value)
    {
        $this->hasPositionChange = true;

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
        $hasPositionChange = false
    ) {
        $this->parentId = $parentId;
        $this->direction = $direction;
        $this->neighbor = $neighbor;
        $this->hasPositionChange = $hasPositionChange;

        $this->parentStories = Story::defaultOrder()->get();
        $this->getOrderStories();

        if ($neighbor === null) {
            $this->neighbor = optional($this->orderStories->last())->id;
        } else {
            $this->parentId = optional(Story::find($this->neighbor))->parent_id;
        }

        $this->getOrderStories();
    }

    public function render()
    {
        return view('livewire.stories.hierarchy');
    }

    protected function getOrderStories()
    {
        $this->orderStories = Story::whereParent($this->parentId)
            ->defaultOrder()
            ->get();
    }
}
