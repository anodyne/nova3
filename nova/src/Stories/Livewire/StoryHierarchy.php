<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nova\Stories\Models\Story;

class StoryHierarchy extends Component
{
    public $direction;

    public $hasPositionChange = false;

    public $neighbor;

    public ?Story $parent = null;

    public $parentId = null;

    public ?Story $story = null;

    public function updatedDirection($value): void
    {
        $this->hasPositionChange = true;
    }

    public function updatedParentId($value): void
    {
        $this->hasPositionChange = true;

        $this->parent = Story::find($value);
    }

    public function updatedNeighbor($value): void
    {
        $this->hasPositionChange = true;
    }

    public function getOrderStoriesProperty(): Collection
    {
        return Story::query()
            ->when(filled($this->parentId), fn (Builder $query): Builder => $query->parent((int) $this->parentId))
            ->when(blank($this->parentId), fn (Builder $query): Builder => $query->whereNull('parent_id'))
            ->ordered()
            ->get();
    }

    public function getParentStoriesProperty(): Collection
    {
        return Story::tree()->ordered()->get();
    }

    public function mount()
    {
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
    }

    public function render()
    {
        // dd($this->orderStories);

        return view('livewire.stories.hierarchy', [
            'orderStories' => $this->orderStories,
            'parentStories' => $this->parentStories,
        ]);
    }

    protected function getStory($id): Story
    {
        return Story::find($id);
    }
}
