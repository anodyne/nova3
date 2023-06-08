<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;

class ManagePermissions extends Component
{
    public string $search = '';

    public Role $role;

    public function addPermission(Permission $permission): void
    {
        $this->search = '';

        $this->role->givePermission($permission);

        Notification::make()
            ->title('Permission added to role')
            ->body($permission->display_name.' permission has been added to '.$this->role->display_name)
            ->success()
            ->send();
    }

    public function removePermission(Permission $permission): void
    {
        $this->role->removePermission($permission);

        Notification::make()
            ->title('Permission removed from role')
            ->body($permission->display_name.' permission has been removed from '.$this->role->display_name)
            ->success()
            ->send();
    }

    public function getPermissionsProperty()
    {
        return $this->role->permissions;
    }

    public function getFilteredPermissionsProperty()
    {
        return Permission::query()
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query) => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query) => $query)
            ->get();
    }

    public function render()
    {
        return view('livewire.roles.manage-permissions', [
            'permissions' => $this->permissions,
            'filteredPermissions' => $this->filteredPermissions,
        ]);
    }
}
