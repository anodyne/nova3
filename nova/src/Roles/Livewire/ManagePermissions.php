<?php

namespace Nova\Roles\Livewire;

use Livewire\Component;
use Nova\Roles\Models\Permission;
use Illuminate\Support\Collection;

class ManagePermissions extends Component
{
    public $permissions = [];

    public $query;

    public $results;

    public function addPermission($permissionId, $permission)
    {
        $this->permissions[$permissionId] = $permission;

        $this->dispatchBrowserEvent('dropdown-close');

        $this->query = null;
        $this->results = null;
    }

    public function removePermission($permissionId)
    {
        unset($this->permissions[$permissionId]);
    }

    public function updatedQuery($value)
    {
        $this->results = Permission::query()
            ->where('name', 'like', "%{$value}%")
            ->orWhere('display_name', 'like', "%{$value}%")
            ->orderBy('display_name')
            ->get();
    }

    public function mount($permissions)
    {
        Collection::wrap($permissions)
            ->each(function ($permission) {
                $this->permissions[$permission->id] = $permission->toArray();
            });
    }

    public function render()
    {
        return view('livewire.roles.manage-permissions');
    }
}
