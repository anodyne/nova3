<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

class ManageUsers extends Component
{
    public string $search = '';

    public bool $onlyActive = true;

    public Role $role;

    public function assignUser(User $user): void
    {
        $this->search = '';

        $user->addRole($this->role);

        Notification::make()
            ->title('Role given to user')
            ->body($user->name.' has been given the '.$this->role->display_name.' role')
            ->success()
            ->send();
    }

    public function unassignUser(User $user): void
    {
        $user->removeRole($this->role);

        Notification::make()
            ->title('Role removed from user')
            ->body($this->role->display_name.' role has been removed from '.$user->name)
            ->success()
            ->send();
    }

    public function getUsersProperty()
    {
        return $this->role->user()
            ->when($this->onlyActive, fn (Builder $query) => $query->active())
            ->get();
    }

    public function getFilteredUsersProperty()
    {
        return User::query()
            ->when($this->onlyActive, fn (Builder $query) => $query->active())
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query) => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query) => $query)
            ->get();
    }

    public function render()
    {
        return view('livewire.roles.manage-users', [
            'users' => $this->users,
            'filteredUsers' => $this->filteredUsers,
        ]);
    }
}
