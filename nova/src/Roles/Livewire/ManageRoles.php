<?php

namespace Nova\Roles\Livewire;

use Livewire\Component;
use Nova\Roles\Models\Role;
use Illuminate\Support\Collection;

class ManageRoles extends Component
{
    public $query;

    public $results;

    public $roles = [];

    public function addRole($roleId, $role)
    {
        $this->dispatchBrowserEvent('dropdown-close');

        $this->roles[$roleId] = $role;

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
        $roles = Collection::wrap($roles);

        $roles->each(function ($role) {
            $this->roles[$role->id] = $role->toArray();
        });
    }

    public function render()
    {
        return view('livewire.roles.manage-roles');
    }
}
