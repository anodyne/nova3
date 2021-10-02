<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Livewire\Component;
use Nova\Foundation\Livewire\DataTable\WithPerPagePagination;
use Nova\Foundation\Livewire\DataTable\WithSorting;
use Nova\Roles\Models\Role;

class ManagePermissions extends Component
{
    use WithPerPagePagination;
    use WithSorting;

    public $listeners = [
        'permissionsSelected' => 'attachSelectedPermissions',
    ];

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
    }

    /**
     * Detach selected permissions from the role.
     */
    public function detachSelectedPermissions(): void
    {
        $this->dispatchBrowserEvent('dropdown-close');

        $this->role->detachPermissions($this->selected);
    }

    /**
     * Select all permissions.
     */
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
            ? $this->rows->pluck('id')->map(fn ($id) => (string) $id)
            : [];
    }

    /**
     * Get the query for the rows to be displayed in the data table.
     */
    public function getRowsQueryProperty()
    {
        $query = $this->role->permissions();

        return $this->applySorting($query);
    }

    /**
     * Get the paginated rows to be displayed in the data table.
     */
    public function getRowsProperty()
    {
        return $this->applyPagination(
            $this->rowsQuery,
            $this->columns,
            'permissionsPage'
        );
    }

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function render()
    {
        return view('livewire.roles.manage-permissions', [
            'permissions' => $this->rows,
        ]);
    }
}
