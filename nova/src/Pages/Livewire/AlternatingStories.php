<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Stories\Models\Story;

class AlternatingStories extends Component
{
    public ?string $type = null;

    public array $selectedStories = [];

    public bool $dark = false;

    public bool $showDescription = true;

    public bool $showStats = false;

    #[Computed]
    public function stories(): Collection
    {
        return Story::query()
            ->with('children')
            ->withCount('posts', 'recursivePosts')
            ->withSum(['recursivePosts', 'posts'], 'word_count')
            ->when($this->type === 'current', fn (Builder $query): Builder => $query->current())
            ->when($this->type === 'upcoming', fn (Builder $query): Builder => $query->upcoming())
            ->when($this->type === 'ongoing', fn (Builder $query): Builder => $query->ongoing())
            ->when($this->type === 'custom', fn (Builder $query): Builder => $query->whereIn('id', $this->selectedStories))
            ->get();
    }

    public function render()
    {
        return view('pages.pages.livewire.alternating-stories', [
            'stories' => $this->stories,
        ]);
    }
}
