<?php

namespace Nova\Stories\Livewire;

use Livewire\Component;
use Nova\Stories\Models\Story;

class StoryHierarchy extends Component
{
    public $parentId;

    public $direction;

    public $neighbor;

    public $orderStories;

    public $parentStories;

    public function updatedParentId($value)
    {
        $this->getOrderStories();
    }

    public function mount($parentId = 1, $direction = 'before', $neighbor = null)
    {
        $this->parentId = $parentId;
        $this->direction = $direction;
        $this->neighbor = $neighbor;

        $this->parentStories = Story::defaultOrder()->get();
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
