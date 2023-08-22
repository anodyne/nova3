<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

class ManageUsers extends Component
{
    public string $search = '';

    public ?Role $role = null;

    public Collection $assigned;

    public function assignUser(User $user): void
    {
        $this->search = '';

        $this->assigned->push($user);
    }

    public function unassignUser(User $user): void
    {
        $this->assigned = $this->assigned->reject(
            fn (User $collectionUser) => $collectionUser->id === $user->id
        );
    }

    public function getUsersProperty(): Collection
    {
        return $this->assigned;
    }

    public function getFilteredUsersProperty(): Collection
    {
        return User::query()
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query): Builder => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query): Builder => $query)
            ->get();
    }

    public function getAssignedUsersProperty(): string
    {
        return $this->assigned
            ->map(fn (User $user) => $user->id)
            ->join(',');
    }

    public function mount(): void
    {
        $this->assigned = $this->role?->user ?? Collection::make();
    }

    public function render()
    {
        return view('livewire.roles.manage-users', [
            'assignedUsers' => $this->assignedUsers,
            'filteredUsers' => $this->filteredUsers,
            'users' => $this->users,
        ]);
    }
}
