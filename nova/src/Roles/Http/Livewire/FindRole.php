<?php

namespace Nova\Roles\Http\Livewire;

use Livewire\Component;
use Nova\Roles\Models\Role;

class FindRole extends Component
{
    public $roles;

    public $query;

    public $results;

    public function addRole($roleId, $role)
    {
        $this->roles[$roleId] = $role;

        $this->dispatchBrowserEvent('dropdown-close');

        $this->query = '';
    }

    public function removeRole($roleId)
    {
        unset($this->roles[$roleId]);
    }

    public function updatedQuery($value)
    {
        $this->results = Role::query()
            ->where('name', 'like', "%{$value}%")
            ->orWhere('display_name', 'like', "%{$value}%")
            ->orderBy('display_name')
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
        return view('livewire.roles.find-role');
    }
}
