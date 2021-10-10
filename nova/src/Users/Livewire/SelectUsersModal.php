<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use Nova\Users\Models\User;

class SelectUsersModal extends ModalComponent
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
            'roles:manage-users' => ['usersSelected', [$this->selected]],
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
     * Get a subset of all users based on the search.
     */
    public function getFilteredUsersProperty(): Collection
    {
        if ($this->search === '') {
            return collect();
        }

        return User::query()
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
        return view('livewire.users.select-users-modal', [
            'filteredUsers' => $this->filteredUsers,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
