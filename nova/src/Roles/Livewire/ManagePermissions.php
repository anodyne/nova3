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

    public $filters = [
        'search' => '',
    ];

    public $listeners = [
        'permissionsSelected' => 'attachSelectedPermissions',
    ];

    public Role $role;

    /**
     * Attach the permissions to the role that we get from the modal.
     */
    public function attachSelectedPermissions(array $permissions): void
    {
        $permissionsToAdd = collect($permissions)
            ->diff($this->role->permissions()->pluck('id'));

        if ($permissionsToAdd->count() > 0) {
            $this->role->attachPermissions($permissionsToAdd->all());
        }
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
            ->when($this->filters['search'], function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    return $q->where('name', 'like', "%{$search}%")
                        ->orWhere('display_name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
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

    /**
     * Select all permissions.
     */
    public function selectAll()
    {
        $this->selectAll = true;

        $this->selected = $this->role->permissions->pluck('id')->map(fn ($id) => (string) $id);
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
