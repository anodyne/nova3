<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use LivewireUI\Modal\ModalComponent;
use Nova\Users\Models\User;

class SelectUsersModal extends ModalComponent
{
    public Collection $allUsers;

    public string $search = '';

    public array $selected = [];

    /**
     * Get the name of a given user.
     */
    public function userName($id): string
    {
        return $this->allUsers->firstWhere('id', $id)->name;
    }

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
        $users = $this->search === '*'
            ? $this->allUsers
            : $this->allUsers
                ->filter(function ($user) {
                    return Str::of($user->name)->contains($this->search)
                        || Str::of($user->email)->contains($this->search);
                });

        return $users->filter(fn ($p) => ! in_array($p->id, $this->selected));
    }

    public function mount()
    {
        $this->allUsers = User::get();
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
