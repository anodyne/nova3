<?php

declare(strict_types=1);

namespace Nova\Search\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Nova\Announcements\Models\Announcement;
use Nova\Characters\Models\Character;
use Nova\Foundation\Livewire\Modal;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

/**
 * @property-read Collection $results
 * @property-read int $numberOfResults
 */
class GlobalSearch extends Modal
{
    public ?string $search = null;

    public array $categories = [
        'announcements',
        'characters',
        'stories',
        'posts',
    ];

    /**
     * @return Collection<string, EloquentCollection<int, Model>>
     */
    #[Computed]
    public function results(): Collection
    {
        /** @var Collection<string, EloquentCollection<int, Model>> $results */
        $results = collect();

        if (blank($this->search)) {
            return $results;
        }

        $results
            ->when(in_array('announcements', $this->categories))
            ->put('Announcements', Announcement::search($this->search)->get());

        $results
            ->when(in_array('characters', $this->categories))
            ->put(
                'Characters',
                Character::search($this->search)
                    ->query(fn (Builder $query): Builder => $query->with(['positions', 'rank.name']))
                    ->get()
            );

        $results
            ->when(in_array('posts', $this->categories))
            ->put(
                'Story posts',
                Post::search($this->search)
                    ->query(fn (Builder $query): Builder => $query->with('story'))
                    ->get()
            );

        $results
            ->when(in_array('stories', $this->categories))
            ->put('Stories', Story::search($this->search)->get());

        return $results;
    }

    #[Computed]
    public function numberOfResults(): int
    {
        return $this->results
            ->sum(fn (EloquentCollection $results): int => $results->count());
    }

    public function render(): Factory|View
    {
        return view('livewire.search.index', [
            'numberOfResults' => $this->numberOfResults,
            'results' => $this->results,
        ]);
    }

    public static function size(): string
    {
        return '2xl';
    }
}
