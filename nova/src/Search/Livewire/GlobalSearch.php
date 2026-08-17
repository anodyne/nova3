<?php

declare(strict_types=1);

namespace Nova\Search\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    #[Computed]
    public function results(): Collection
    {
        $results = Collection::make();

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

    public static function size(): string
    {
        return '2xl';
    }
}
