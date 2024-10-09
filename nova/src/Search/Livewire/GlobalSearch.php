<?php

declare(strict_types=1);

namespace Nova\Search\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Announcements\Models\Announcement;
use Nova\Characters\Models\Character;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

class GlobalSearch extends Component
{
    public ?string $search = null;

    #[Computed]
    public function results(): Collection
    {
        $results = Collection::make();

        $results->put('Announcements', Announcement::search($this->search)->get());

        $results->put(
            'Characters',
            Character::search($this->search)
                ->query(fn (Builder $query): Builder => $query->with(['positions', 'rank.name']))
                ->get()
        );

        $results->put(
            'Story posts',
            Post::search($this->search)
                ->query(fn (Builder $query): Builder => $query->with('story'))
                ->get()
        );

        $results->put('Stories', Story::search($this->search)->get());

        return $results;
    }

    #[Computed]
    public function numberOfResults(): int
    {
        return $this->results
            ->map(fn ($collection) => count($collection))
            ->sum();
    }

    public function render()
    {
        return view('livewire.search.index', [
            'numberOfResults' => $this->numberOfResults,
            'results' => $this->results,
        ]);
    }
}
