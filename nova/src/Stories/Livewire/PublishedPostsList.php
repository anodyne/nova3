<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Stories\Enums\PostSorting;
use Nova\Stories\Models\Builders\PostBuilder;
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

    public ?CarbonInterface $maxDate = null;

    public ?CarbonInterface $minDate = null;

    public bool $multiStory = false;

    public ?string $search = '';

    public ?int $selected = null;

    public PostSorting $sort = PostSorting::PublishedDescending;

    public ?Story $story = null;

    public array $types = [];

    public function mount(): void
    {
        $this->types = $this->initialPostTypes();
    }

    #[Computed]
    public function posts(): LengthAwarePaginator
    {
        return Post::with(['characterAuthors', 'userAuthors'])
            ->when(filled($this->search), fn (PostBuilder $query): PostBuilder => $query->searchFor($this->search))
            ->when(filled($this->story), fn (PostBuilder $query): PostBuilder => $query->forStory($this->story))
            ->when(filled($this->selectedStory), fn (PostBuilder $query): PostBuilder => $query->forStory($this->selectedStory))
            ->when(filled($this->minDate), fn (PostBuilder $query): PostBuilder => $query->where('published_at', '>=', $this->minDate))
            ->when(filled($this->maxDate), fn (PostBuilder $query): PostBuilder => $query->where('published_at', '<=', $this->maxDate))
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

    public function render(): View
    {
        return view('pages.posts.livewire.published-posts-list', [
            'posts' => $this->posts,
            'postTypes' => $this->postTypes,
            'selectedStory' => $this->selectedStory,
            'stories' => $this->stories,
        ]);
    }

    public function resetFilters(): void
    {
        $this->sort = PostSorting::PublishedDescending;
        $this->types = $this->initialPostTypes();
        $this->selected = null;
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
