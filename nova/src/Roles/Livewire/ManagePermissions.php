<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Roles\Models\Role;

class ManagePermissions extends Component
{
    public $listeners = [
        'permissionSelected',
    ];

    public ?Collection $permissions;

    public ?Role $role;

    public function permissionSelected($permissionId): void
    {
        logger('permission selected', ['role' => $this->role->id, 'permission' => $permissionId]);

        $this->role->attachPermission($permissionId);

        $this->role->refresh();

        $this->permissions = $this->role->permissions;
    }

    public function removePermission($permissionId): void
    {
        $this->role->detachPermission($permissionId);

        $this->role->refresh();

        $this->permissions = $this->role->permissions;
    }

    public function mount(?Role $role)
    {
        $this->role = $role;
        $this->permissions = Collection::wrap($role->permissions);
    }

    public function render()
    {
        return view('livewire.roles.manage-permissions');
    }
}
