<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use Nova\Posts\Models\Post;

class SelectTimeModal extends ModalComponent
{
    public ?string $time = '';

    public string $search = '';

    public string $selected = '';

    public $storyId;

    /**
     * Apply the the selected time to the post.
     */
    public function apply(): void
    {
        $this->closeModalWithEvents([
            'posts:step:write-post' => ['timeSelected', [$this->selected]],
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
     * Get a subset of all times from the current story based on the search.
     */
    public function getFilteredTimesProperty(): Collection
    {
        return Post::query()
            ->select('time')
            ->story($this->storyId)
            ->wherePublished()
            ->when(
                $this->search,
                fn ($query, $search) => $query->where('time', 'like', "%{$search}%")
            )
            ->when(
                $this->time,
                fn ($query, $time) => $query->where('time', '!=', $time)
            )
            ->whereNotNull('time')
            ->orderBy('time')
            ->groupBy('time')
            ->get()
            ->map(fn ($post) => $post->time);
    }

    /**
     * Set the time when they click the use button.
     */
    public function setNewTime(): void
    {
        $this->selected = $this->search;

        $this->apply();
    }

    public function mount($storyId, $time)
    {
        $this->storyId = $storyId;
        $this->time = $time;

        if ($time) {
            $this->selected = $time;
        }
    }

    public function render()
    {
        return view('livewire.posts.select-time-modal', [
            'filteredTimes' => $this->filteredTimes,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
