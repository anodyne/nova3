<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

class ManageRoles extends Component
{
    public string $search = '';

    public ?User $user = null;

    public Collection $assigned;

    public function add(Role $role): void
    {
        $this->search = '';

        $this->assigned->push($role);
    }

    public function remove(Role $role): void
    {
        $this->assigned = $this->assigned->reject(
            fn (Role $collectionRole) => $collectionRole->id === $role->id
        );
    }

    #[Computed]
    public function assignedRoles(): string
    {
        return $this->assigned
            ->map(fn (Role $role) => $role->id)
            ->join(',');
    }

    #[Computed]
    public function roles(): Collection
    {
        return $this->user?->roles ?? Collection::make();
    }

    #[Computed]
    public function searchResults(): Collection
    {
        return Role::query()
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query) => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query) => $query)
            ->get();
    }

    public function mount(): void
    {
        $this->assigned = $this->user?->roles ?? Collection::make();
    }

    public function render()
    {
        return view('pages.users.livewire.manage-roles', [
            'assignedRoles' => $this->assignedRoles,
            'roles' => $this->roles,
            'searchResults' => $this->searchResults,
        ]);
    }
}
