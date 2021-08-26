<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Roles\Models\Role;

class ManageRoles extends Component
{
    public $search = null;

    public $results = null;

    public $roles = [];

    public function addRole($roleId, $role)
    {
        $this->dispatchBrowserEvent('dropdown-close');

        $this->roles[$roleId] = $role;

        $this->reset(['search', 'results']);
    }

    public function removeRole($roleId)
    {
        unset($this->roles[$roleId]);
    }

    public function updatedSearch($value)
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

        $this->roles = $roles
            ->mapWithKeys(fn ($role) => [$role->id => $role->toArray()])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.roles.manage-roles');
    }
}
