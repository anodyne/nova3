<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

class ManageUsers extends Component
{
    #[Locked]
    public ?Role $role = null;

    public Collection $assigned;

    public ?string $selected = null;

    public function remove(User $user): void
    {
        $this->assigned = $this->assigned->reject(
            fn (User $collectionUser) => $collectionUser->id === $user->id
        );

        $this->dispatch('users-updated', users: $this->assigned->pluck('id')->all());
    }

    public function updatedSelected(User $value): void
    {
        $this->assigned->push($value);

        $this->selected = null;
    }

    public function mount(): void
    {
        $this->assigned = $this->role?->user ?? Collection::make();
    }

    public function render()
    {
        return view('pages.roles.livewire.manage-users', [
            'assignedUsers' => $this->assignedUsers,
            'models' => $this->models,
            'users' => $this->users,
        ]);
    }

    #[Computed]
    public function assignedUsers(): string
    {
        return $this->assigned
            ->map(fn (User $user) => $user->id)
            ->join(',');
    }

    #[Computed]
    public function models(): Collection
    {
        return User::get();
    }

    #[Computed]
    public function users(): Collection
    {
        return $this->assigned;
    }
}
