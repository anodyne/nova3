<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class SelectCharactersModal extends ModalComponent
{
    public string $search = '';

    public array $selected = [];

    public array $selectedDisplay = [];

    /**
     * Apply the the selected users to the role.
     */
    public function apply(): void
    {
        $this->closeModalWithEvents([
            'users:manage-characters' => ['charactersSelected', [$this->selected]],
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
     * Get a subset of all characters based on the search.
     */
    public function getFilteredCharactersProperty(): Collection
    {
        if ($this->search === '') {
            return collect();
        }

        return Character::query()
            ->unless($this->search === '*', fn ($query) => $query->searchFor($this->search))
            ->whereNotIn('id', $this->selected)
            ->whereNotPending()
            ->get();
    }

    /**
     * Keep track of a tuple of IDs and names from the selected list.
     */
    public function updatedSelected(): void
    {
        $this->selectedDisplay = User::query()
            ->whereIn('id', $this->selected)
            ->get()
            ->pluck('name', 'id')
            ->all();
    }

    public function render()
    {
        return view('livewire.characters.select-characters-modal', [
            'filteredCharacters' => $this->filteredCharacters,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
