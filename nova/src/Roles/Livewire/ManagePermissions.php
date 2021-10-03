<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Livewire\Component;
use Nova\Foundation\Livewire\DataTable\WithBulkActions;
use Nova\Foundation\Livewire\DataTable\WithPerPagePagination;
use Nova\Foundation\Livewire\DataTable\WithSorting;
use Nova\Roles\Models\Role;

class ManagePermissions extends Component
{
    use WithBulkActions;
    use WithPerPagePagination;
    use WithSorting;

    public $listeners = [
        'permissionsSelected' => 'attachSelectedPermissions',
    ];

    public Role $role;

    public string $search = '';

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
        if ($this->selectAll) {
            $this->role->syncPermissions([]);
        } else {
            $this->role->detachPermissions($this->selected);
        }

        $this->selected = [];
    }

    /**
     * Get the query for the rows to be displayed in the data table.
     */
    public function getRowsQueryProperty()
    {
        $query = $this->role
            ->permissions()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    return $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('display_name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            });

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
