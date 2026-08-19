<?php

declare(strict_types=1);

namespace Nova\PublicSite\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

/**
 * @property-read Collection $stories
 */
class StoriesTimeline extends Component
{
    public string $sortDirection = 'asc';

    public string $bgColor = '#ffffff';

    #[Computed]
    public function stories(): Collection
    {
        return Story::tree()
            ->withCountsAndSums()
            ->exceptUpcoming()
            ->orderBy('order_column', $this->sortDirection)
            ->get()
            ->toTree();
    }

    public function render(): Factory|View
    {
        return view('pages.public-site.livewire.stories-timeline', [
            'stories' => $this->stories,
        ]);
    }
}
