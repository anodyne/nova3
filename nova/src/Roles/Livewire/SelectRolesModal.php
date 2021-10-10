<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use Nova\Roles\Models\Role;

class SelectRolesModal extends ModalComponent
{
    public string $search = '';

    public array $selected = [];

    public array $selectedDisplay = [];

    /**
     * Apply the the selected roles to the user.
     */
    public function apply(): void
    {
        $this->closeModalWithEvents([
            'users:manage-roles' => ['rolesSelected', [$this->selected]],
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
     * Get a subset of all roles based on the search.
     */
    public function getFilteredRolesProperty(): Collection
    {
        if ($this->search === '') {
            return collect();
        }

        return Role::query()
            ->unless($this->search === '*', fn ($query) => $query->searchFor($this->search))
            ->whereNotIn('id', $this->selected)
            ->get();
    }

    /**
     * Keep track of a tuple of IDs and names from the selected list.
     */
    public function updatedSelected(): void
    {
        $this->selectedDisplay = Role::query()
            ->whereIn('id', $this->selected)
            ->get()
            ->pluck('display_name', 'id')
            ->all();
    }

    public function render()
    {
        return view('livewire.roles.select-roles-modal', [
            'filteredRoles' => $this->filteredRoles,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
