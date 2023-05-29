<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Nova\Roles\Models\Role;
use Nova\Users\Actions\SetUserRoles;
use Nova\Users\Models\User;

class ManageRoles extends Component
{
    public string $search = '';

    public User $user;

    public function assignRole(Role $role): void
    {
        $this->search = '';

        SetUserRoles::run(
            $this->user,
            $this->user->roles->pluck('id')->concat([$role->id])->all()
        );

        Notification::make()
            ->title('Role assigned to user')
            ->body($role->display_name.' role has been given to '.$this->user->name)
            ->success()
            ->send();
    }

    public function unassignRole(Role $role): void
    {
        SetUserRoles::run(
            $this->user,
            $this->user->roles->pluck('id')->diff($role->id)->all()
        );

        Notification::make()
            ->title('Role unassigned from user')
            ->body($role->display_name.' role has been removed from '.$this->user->name)
            ->success()
            ->send();
    }

    public function getRolesProperty()
    {
        return $this->user->roles;
    }

    public function getFilteredRolesProperty()
    {
        return Role::query()
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query) => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query) => $query)
            ->get();
    }

    public function render()
    {
        return view('livewire.users.manage-roles', [
            'roles' => $this->roles,
            'filteredRoles' => $this->filteredRoles,
        ]);
    }
}
