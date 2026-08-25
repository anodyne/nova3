<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

/**
 * @property-read Collection<int, Story> $stories
 */
class StoriesTimeline extends Component
{
    public string $sortField = 'order_column';

    public string $sortDirection = 'desc';

    /** @return Collection<int, Story> */
    #[Computed]
    public function stories(): Collection
    {
        return Story::tree()
            ->withCountsAndSums()
            ->orderBy($this->sortField, $this->sortDirection)
            ->get()
            ->toTree();
    }

    public function render(): View
    {
        return view('pages.stories.livewire.timeline', [
            'stories' => $this->stories,
        ]);
    }
}
