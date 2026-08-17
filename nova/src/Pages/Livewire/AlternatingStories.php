<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Story;

/**
 * @property-read bool $showDescription
 * @property-read bool $showStats
 * @property-read Collection $stories
 */
class AlternatingStories extends Component
{
    public ?string $type = null;

    public array $blockSettings = [];

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

    #[Computed]
    public function stories(): Collection
    {
        return Story::query()
            ->with('children')
            ->withCountsAndSums()
            ->when($this->type === 'current', fn (Builder $query): Builder => $query->current())
            ->when($this->type === 'upcoming', fn (Builder $query): Builder => $query->upcoming())
            ->when($this->type === 'ongoing', fn (Builder $query): Builder => $query->ongoing())
            ->when($this->type === 'custom', fn (Builder $query): Builder => $query->whereIn('id', data_get($this->blockSettings, 'selectedStories')))
            ->get();
    }

    public function render()
    {
        return view('pages.pages.livewire.alternating-stories', [
            'showDescription' => $this->showDescription,
            'showStats' => $this->showStats,
            'stories' => $this->stories,
        ]);
    }
}
