<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Builders\StoryBuilder;
use Nova\Stories\Models\Story;

/**
 * @property-read bool $showDescription
 * @property-read bool $showStats
 * @property-read Collection<int, Story> $stories
 */
class AlternatingStories extends Component
{
    public array $blockSettings = [];

    public ?string $type = null;

    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        return view('pages.pages.livewire.alternating-stories', [
            'showDescription' => $this->showDescription,
            'showStats' => $this->showStats,
            'stories' => $this->stories,
        ]);
    }

    #[Computed]
    public function showDescription(): bool
    {
        return (bool) data_get($this->blockSettings, 'showStoryDescription');
    }

    #[Computed]
    public function showStats(): bool
    {
        return (bool) data_get($this->blockSettings, 'showStoryStats');
    }

    /**
     * @return Collection<int, Story>
     */
    #[Computed]
    public function stories(): Collection
    {
        return Story::query()
            ->withCountsAndSums()
            ->when($this->type === 'current', fn (StoryBuilder $query): StoryBuilder => $query->current())
            ->when($this->type === 'upcoming', fn (StoryBuilder $query): StoryBuilder => $query->upcoming())
            ->when($this->type === 'ongoing', fn (StoryBuilder $query): StoryBuilder => $query->ongoing())
            ->when($this->type === 'custom', fn (StoryBuilder $query): StoryBuilder => $query->whereIn('id', data_get($this->blockSettings, 'selectedStories')))
            ->with(['children'])
            ->get();
    }
}
