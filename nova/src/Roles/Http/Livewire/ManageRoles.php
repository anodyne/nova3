<?php

namespace Nova\Roles\Http\Livewire;

use Livewire\Component;
use Nova\Roles\Models\Role;

class ManageRoles extends Component
{
    public $roles = [];

    public $query;

    public $results;

    public function addRole($roleId, $role)
    {
        $this->roles[$roleId] = $role;

        $this->dispatchBrowserEvent('dropdown-close');

        $this->query = null;
        $this->results = null;
    }

    public function removeRole($roleId)
    {
        unset($this->roles[$roleId]);
    }

    public function updatedQuery($value)
    {
        $this->results = Role::query()
            ->whereAtOrBelowSortOrder(
                auth()->user()->roles()->orderBySort()->first()->sort
            )
            ->where(function ($query) use ($value) {
                return $query->where('name', 'like', "%{$value}%")
                    ->orWhere('display_name', 'like', "%{$value}%");
            })
            ->orderBySort()
            ->get();
    }

    public function mount($roles)
    {
        $roles->each(function ($role) {
            $this->roles[$role->id] = $role->toArray();
        });
    }

    public function render()
    {
        return view('livewire.roles.manage-roles');
    }
}
