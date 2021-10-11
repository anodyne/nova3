<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use Nova\Roles\Models\Permission;

class SelectPermissionsModal extends ModalComponent
{
    public string $search = '';

    public array $selected = [];

    public array $selectedDisplay = [];

    /**
     * Emit events with the selected permissions.
     */
    public function apply(): void
    {
        $this->closeModalWithEvents([
            'roles:manage-permissions' => ['permissionsSelected', [$this->selected]],
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
     * Get a subset of all permissions based on the search.
     */
    public function getFilteredPermissionsProperty(): Collection
    {
        if ($this->search === '') {
            return collect();
        }

        return Permission::query()
            ->unless($this->search === '*', fn ($query) => $query->searchFor($this->search))
            ->whereNotIn('id', $this->selected)
            ->get();
    }

    /**
     * Keep track of a tuple of IDs and display names from the selected list.
     */
    public function updatedSelected(): void
    {
        $this->selectedDisplay = Permission::query()
            ->whereIn('id', $this->selected)
            ->get()
            ->pluck('display_name', 'id')
            ->all();
    }

    public function render()
    {
        return view('livewire.roles.select-permissions-modal', [
            'filteredPermissions' => $this->filteredPermissions,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
