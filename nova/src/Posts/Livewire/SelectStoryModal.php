<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use Nova\Stories\Models\Story;

class SelectStoryModal extends ModalComponent
{
    public ?int $story = 0;

    public string $search = '';

    public int $selected = 0;

    public array $selectedDisplay = [];

    /**
     * Apply the the selected location to the post.
     */
    public function apply(): void
    {
        $this->closeModalWithEvents([
            'posts:step:write-post' => ['storySelected', [$this->selected]],
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
     * Get a subset of all stories based on the search.
     */
    public function getFilteredStoriesProperty(): Collection
    {
        return Story::query()
            ->whereCurrent()
            ->when(
                $this->search,
                fn ($query, $search) => $query->where('title', 'like', "%{$search}%")
            )
            // ->when(
            //     $this->story,
            //     fn ($query, $story) => $query->where('id', '!=', $story)
            // )
            ->orderBy('_lft')
            ->get();
    }

    /**
     * Set the location when they click the use button.
     */
    public function setNewStory(): void
    {
        $this->selected = $this->search;

        $this->apply();
    }

    /**
     * Keep track of a tuple of IDs and display names from the selected list.
     */
    public function updatedSelected(): void
    {
        $this->selectedDisplay = Story::query()
            ->where('id', $this->selected)
            ->get()
            ->pluck('title', 'id')
            ->all();
    }

    public function mount($story)
    {
        $this->story = $story;

        if ($story) {
            $this->selected = $story;

            $this->updatedSelected();
        }
    }

    public function render()
    {
        return view('livewire.posts.select-story-modal', [
            'filteredStories' => $this->filteredStories,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
