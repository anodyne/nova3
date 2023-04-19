<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use Nova\Posts\Models\Post;

class SelectLocationModal extends ModalComponent
{
    public ?string $location = '';

    public string $search = '';

    public string $selected = '';

    public $storyId;

    /**
     * Apply the the selected location to the post.
     */
    public function apply(): void
    {
        $this->closeModalWithEvents([
            'posts:step:write-post' => ['locationSelected', [$this->selected]],
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
     * Get a subset of all locations from the current story based on the search.
     */
    public function getFilteredLocationsProperty(): Collection
    {
        return Post::query()
            ->select('location')
            ->story($this->storyId)
            ->wherePublished()
            ->when(
                $this->search,
                fn ($query, $search) => $query->where('location', 'like', "%{$search}%")
            )
            ->when(
                $this->location,
                fn ($query, $location) => $query->where('location', '!=', $location)
            )
            ->whereNotNull('location')
            ->orderBy('location')
            ->groupBy('location')
            ->get()
            ->map(fn ($post) => $post->location);
    }

    /**
     * Set the location when they click the use button.
     */
    public function setNewLocation(): void
    {
        $this->selected = $this->search;

        $this->apply();
    }

    public function mount($storyId, $location)
    {
        $this->storyId = $storyId;
        $this->location = $location;

        if ($location) {
            $this->selected = $location;
        }
    }

    public function render()
    {
        return view('livewire.posts.select-location-modal', [
            'filteredLocations' => $this->filteredLocations,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
