<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;

class ManagePermissions extends Component
{
    public string $search = '';

    #[Locked]
    public ?Role $role = null;

    public Collection $assigned;

    public function add(Permission $permission): void
    {
        $this->search = '';

        $this->assigned->push($permission);
    }

    public function remove(Permission $permission): void
    {
        $this->assigned = $this->assigned->reject(
            fn (Permission $collectionPermission) => $collectionPermission->id === $permission->id
        );
    }

    #[Computed]
    public function assignedPermissions(): string
    {
        return $this->assigned
            ->map(fn (Permission $permission) => $permission->id)
            ->join(',');
    }

    #[Computed]
    public function permissions(): Collection
    {
        return $this->assigned;
    }

    #[Computed]
    public function searchResults(): Collection
    {
        return Permission::query()
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query): Builder => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query): Builder => $query)
            ->whereNotIn('id', $this->assigned->map(fn (Permission $permission) => $permission->id)->all())
            ->get();
    }

    public function mount(): void
    {
        $this->assigned = $this->role?->permissions ?? Collection::make();
    }

    public function render()
    {
        return view('pages.roles.livewire.manage-permissions', [
            'assignedPermissions' => $this->assignedPermissions,
            'searchResults' => $this->searchResults,
            'permissions' => $this->permissions,
        ]);
    }
}
