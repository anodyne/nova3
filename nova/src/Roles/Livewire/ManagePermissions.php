<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Nova\Roles\Models\Role;

class ManagePermissions extends Component
{
    use WithPagination;

    public $listeners = [
        'permissionsSelected' => 'attachSelectedPermissions',
    ];

    // public $permissions;

    public ?Role $role;

    public $selected = [];

    public $selectPage = false;

    public $selectAll = false;

    /**
     * Attach the permissions to the role that we get from the modal.
     */
    public function attachSelectedPermissions(array $permissions): void
    {
        $this->role->attachPermissions($permissions);

        $this->getPermissions();
    }

    /**
     * Detach selected permissions from the role.
     */
    public function detachSelectedPermissions(): void
    {
        $this->dispatchBrowserEvent('dropdown-close');

        $this->role->detachPermissions($this->selected);

        $this->getPermissions();
    }

    public function selectAll(): void
    {
        $this->selectAll = true;
    }

    /**
     * Set the selected permissions when the select page property is changed.
     */
    public function updatedSelectPage($value): void
    {
        $this->selected = $value
            ? $this->permissions->pluck('id')->map(fn ($id) => (string) $id)
            : [];
    }

    public function getRowsQueryProperty()
    {
        $query = $this->roles->permissions();

        return $query;

        // return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function mount(?Role $role)
    {
        $this->role = $role;

        $this->getPermissions();
    }

    public function render()
    {
        return view('livewire.roles.manage-permissions', [
            'permissions' => $this->rows,
        ]);
    }

    protected function getPermissions(): void
    {
        $this->role->refresh();

        // $this->permissions = $this->role->permissions->paginate();
    }
}
