<?php

declare(strict_types=1);

namespace Nova\Search\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Nova\Announcements\Models\Announcement;
use Nova\Characters\Models\Character;
use Nova\Foundation\Livewire\Modal;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

/**
 * @property-read Collection<string, EloquentCollection<int, Announcement>|EloquentCollection<int, Character>|EloquentCollection<int, Post>|EloquentCollection<int, Story>> $results
 * @property-read int $numberOfResults
 */
class GlobalSearch extends Modal
{
    public ?string $search = null;

    /** @var list<string> */
    public array $categories = [
        'announcements',
        'characters',
        'stories',
        'posts',
    ];

    /**
     * @return Collection<string, EloquentCollection<int, Announcement>|EloquentCollection<int, Character>|EloquentCollection<int, Post>|EloquentCollection<int, Story>>
     */
    #[Computed]
    public function results(): Collection
    {
        $results = [];

        if (blank($this->search)) {
            return collect($results);
        }

        if (in_array('announcements', $this->categories)) {
            $results['Announcements'] = Announcement::search($this->search)->get();
        }

        if (in_array('characters', $this->categories)) {
            $results['Characters'] = Character::search($this->search)
                ->query(fn (Builder $query): Builder => $query->with(['positions', 'rank.name']))
                ->get();
        }

        if (in_array('posts', $this->categories)) {
            $results['Story posts'] = Post::search($this->search)
                ->query(fn (Builder $query): Builder => $query->with('story'))
                ->get();
        }

        if (in_array('stories', $this->categories)) {
            $results['Stories'] = Story::search($this->search)->get();
        }

        return collect($results);
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
