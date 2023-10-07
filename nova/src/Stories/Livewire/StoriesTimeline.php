<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Story;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class StoriesTimeline extends Component
{
    public string $sort = 'latest';

    #[Computed]
    public function stories(): Collection
    {
        return Story::tree()
            ->withCount('posts', 'recursivePosts', 'children')
            ->withSum('posts', 'word_count')
            ->when($this->sort === 'oldest', fn (Builder $query) => $query->ordered())
            ->when($this->sort === 'latest', fn (Builder $query) => $query->ordered('desc'))
            ->get()
            ->toTree();
    }

    public function render()
    {
        return view('pages.stories.livewire.timeline', [
            'stories' => $this->stories,
            'storyClass' => Story::class,
        ]);
    }
}
