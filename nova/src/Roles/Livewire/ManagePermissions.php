<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Roles\Models\Permission;

class ManagePermissions extends Component
{
    public $permissions = [];

    public $search;

    public $results;

    public function addPermission($permissionId, $permission): void
    {
        $this->dispatchBrowserEvent('dropdown-close');

        $this->permissions[$permissionId] = $permission;

        $this->reset(['search', 'results']);
    }

    public function removePermission($permissionId): void
    {
        unset($this->permissions[$permissionId]);
    }

    public function updatedSearch($value): void
    {
        $this->results = Permission::query()
            ->where(function ($query) use ($value) {
                return $query->where('name', 'like', "%{$value}%")
                    ->orWhere('display_name', 'like', "%{$value}%");
            })
            ->orderBy('display_name')
            ->get();
    }

    public function mount($permissions)
    {
        $permissions = Collection::wrap($permissions);

        $this->permissions = $permissions
            ->mapWithKeys(fn ($permission) => [$permission->id => $permission->toArray()])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.roles.manage-permissions');
    }
}
