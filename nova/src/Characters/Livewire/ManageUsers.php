<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class ManageUsers extends Component
{
    public string $search = '';

    public ?Character $character = null;

    public Collection $assigned;

    public Collection $primary;

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

    public function setPrimaryCharacterForUser(User $user): void
    {
        $this->primary->push($user);
    }

    public function getUsersProperty(): Collection
    {
        return $this->assigned;
    }

    public function getFilteredUsersProperty(): Collection
    {
        return User::query()
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query) => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query) => $query)
            ->get();
    }

    public function getAssignedUsersProperty(): string
    {
        return $this->assigned
            ->map(fn (User $user) => $user->id)
            ->join(',');
    }

    public function getPrimaryUsersProperty(): string
    {
        return $this->primary
            ->map(fn (User $user) => $user->id)
            ->join(',');
    }

    public function mount(): void
    {
        $this->assigned = $this->character?->users ?? Collection::make();

        $this->primary = $this->character?->primaryUsers ?? Collection::make();
    }

    public function render()
    {
        return view('livewire.characters.manage-users', [
            'assignedUsers' => $this->assignedUsers,
            'filteredUsers' => $this->filteredUsers,
            'primaryUsers' => $this->primaryUsers,
            'users' => $this->users,
        ]);
    }
}
