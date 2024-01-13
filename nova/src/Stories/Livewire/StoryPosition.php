<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Story;

class StoryPosition extends Component
{
    public ?string $direction = 'after';

    public $hasPositionChange = false;

    public ?Story $neighbor = null;

    public ?int $neighborId = null;

    public ?int $parentId = null;

    public ?Story $story = null;

    public function updated($property): void
    {
        $this->hasPositionChange = true;
    }

    #[Computed]
    public function storiesForOrdering(): Collection
    {
        return Story::query()
            ->when(filled($this->parentId), fn (Builder $query): Builder => $query->parent($this->parentId))
            ->when(blank($this->parentId), fn (Builder $query): Builder => $query->whereNull('parent_id'))
            ->ordered()
            ->get();
    }

    #[Computed]
    public function parentStory(): ?Story
    {
        return Story::withCount('stories')->find($this->parentId);
    }

    #[Computed]
    public function parentStories(): Collection
    {
        return Story::tree()->ordered()->get();
    }

    public function mount()
    {
        if (filled($this->story)) {
            $nextNeighbor = $this->story->nextSibling();
            $previousNeighbor = $this->story->previousSibling();

            $this->neighbor = $previousNeighbor ?? $nextNeighbor;
            $this->neighborId = $previousNeighbor?->id ?? $nextNeighbor?->id;

            $this->direction = filled($previousNeighbor) ? 'after' : 'before';

            $this->parentId = $this->story->parent_id;
        } else {
            if (blank($this->neighborId)) {
                $this->neighborId = $this->storiesForOrdering->last()?->id;
            }

            $this->neighbor = $this->getStory($this->neighborId) ?? $this->storiesForOrdering->last();
        }
    }

    public function render()
    {
        return view('pages.stories.livewire.story-position', [
            'parentStory' => $this->parentStory,
            'parentStories' => $this->parentStories,
            'storiesForOrdering' => $this->storiesForOrdering,
        ]);
    }

    protected function getStory($id): ?Story
    {
        return Story::withCount('stories')->find($id);
    }
}
