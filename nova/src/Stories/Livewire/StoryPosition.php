<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Stories\Models\Story;

/**
 * @property-read Collection<int, Story> $storiesForOrdering
 * @property-read Story|null $parentStory
 * @property-read Collection<int, Story> $parentStories
 */
class StoryPosition extends Component
{
    public ?string $direction = 'after';

    public $hasPositionChange = false;

    public ?Story $neighbor = null;

    public ?int $neighborId = null;

    public ?int $parentId = null;

    #[Locked]
    public ?Story $story = null;

    public function mount(): void
    {
        if (filled($this->story)) {
            $nextNeighbor = $this->story->nextSibling();
            $previousNeighbor = $this->story->previousSibling();

            $this->neighbor = $previousNeighbor ?? $nextNeighbor;
            $this->neighborId = $previousNeighbor->id ?? $nextNeighbor?->id;

            $this->direction = filled($previousNeighbor) ? 'after' : 'before';

            $this->parentId = $this->story->parent_id;
        } else {
            if (blank($this->neighborId)) {
                $this->neighborId = $this->storiesForOrdering->last()?->id;
            }

            $this->neighbor = $this->getStory($this->neighborId) ?? $this->storiesForOrdering->last();
        }
    }

    /**
     * @return Collection<int, Story>
     */
    #[Computed]
    public function parentStories(): Collection
    {
        return Story::tree()->ordered()->get();
    }

    #[Computed]
    public function parentStory(): ?Story
    {
        return Story::withCount('stories')->find($this->parentId);
    }

    public function render(): View
    {
        return view('pages.stories.livewire.story-position', [
            'parentStory' => $this->parentStory,
            'parentStories' => $this->parentStories,
            'storiesForOrdering' => $this->storiesForOrdering,
        ]);
    }

    /**
     * @return Collection<int, Story>
     */
    #[Computed]
    public function storiesForOrdering(): Collection
    {
        return Story::query()
            ->whereParent($this->parentId)
            ->ordered()
            ->get();
    }

    public function updated($property): void
    {
        $this->hasPositionChange = true;
    }

    protected function getStory($id): ?Story
    {
        return Story::withCount('stories')->find($id);
    }
}
