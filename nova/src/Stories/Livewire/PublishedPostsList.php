<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Stories\Enums\PostSorting;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\Story;

/**
 * @property-read LengthAwarePaginator $posts
 * @property-read Collection $postTypes
 * @property-read ?Story $selectedStory
 * @property-read Collection $stories
 */
class PublishedPostsList extends Component
{
    use WithPagination;

    public bool $multiStory = false;

    public ?string $search = '';

    public PostSorting $sort = PostSorting::PublishedDescending;

    public array $types = [];

    public ?Story $story = null;

    public ?int $selected = null;

    public ?CarbonInterface $minDate = null;

    public ?CarbonInterface $maxDate = null;

    public function resetFilters(): void
    {
        $this->sort = PostSorting::PublishedDescending;
        $this->types = $this->initialPostTypes();
        $this->selected = null;
    }

    public function mount(): void
    {
        $this->types = $this->initialPostTypes();
    }

    public function render(): View
    {
        return view('pages.posts.livewire.published-posts-list', [
            'posts' => $this->posts,
            'postTypes' => $this->postTypes,
            'selectedStory' => $this->selectedStory,
            'stories' => $this->stories,
        ]);
    }

    #[Computed]
    public function posts(): LengthAwarePaginator
    {
        return Post::with(['characterAuthors', 'userAuthors'])
            ->when(filled($this->search), fn (Builder $query): Builder => $query->searchFor($this->search))
            ->when(filled($this->story), fn (Builder $query): Builder => $query->story($this->story))
            ->when(filled($this->selectedStory), fn (Builder $query): Builder => $query->story($this->selectedStory))
            ->when(filled($this->minDate), fn (Builder $query): Builder => $query->where('published_at', '>=', $this->minDate))
            ->when(filled($this->maxDate), fn (Builder $query): Builder => $query->where('published_at', '<=', $this->maxDate))
            ->whereIn('post_type_id', $this->types)
            ->orderBy($this->sort->getSortColumn(), $this->sort->getSortDirection())
            ->published()
            ->paginate(25);
    }

    #[Computed]
    public function postTypes(): Collection
    {
        return PostType::active()->get();
    }

    #[Computed]
    public function selectedStory(): ?Story
    {
        return Story::find($this->selected);
    }

    #[Computed]
    public function stories(): Collection
    {
        return Story::query()->exceptUpcoming()->get();
    }

    protected function initialPostTypes(): array
    {
        return PostType::active()->pluck('id')->toArray();
    }
}
