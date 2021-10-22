<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use Nova\Posts\Models\Post;

class SelectDayModal extends ModalComponent
{
    public ?string $day = '';

    public string $search = '';

    public string $selected = '';

    public $storyId;

    /**
     * Apply the the selected day to the post.
     */
    public function apply(): void
    {
        $this->closeModalWithEvents([
            'posts:compose' => ['daySelected', [$this->selected]],
        ]);
    }

    /**
     * Dismiss the modal.
     */
    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    /**
     * Get a subset of all days from the current story based on the search.
     */
    public function getFilteredDaysProperty(): Collection
    {
        return Post::query()
            ->select('day')
            ->whereStory($this->storyId)
            ->wherePublished()
            ->when(
                $this->search,
                fn ($query, $search) => $query->where('day', 'like', "%{$search}%")
            )
            ->when(
                $this->day,
                fn ($query, $day) => $query->where('day', '!=', $day)
            )
            ->whereNotNull('day')
            ->orderBy('day')
            ->groupBy('day')
            ->get()
            ->map(fn ($post) => $post->day);
    }

    /**
     * Set the day when they click the use button.
     */
    public function setNewDay(): void
    {
        $this->selected = $this->search;

        $this->apply();
    }

    public function mount($storyId, $day)
    {
        $this->storyId = $storyId;
        $this->day = $day;

        if ($day) {
            $this->selected = $day;
        }
    }

    public function render()
    {
        return view('livewire.posts.select-day-modal', [
            'filteredDays' => $this->filteredDays,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
