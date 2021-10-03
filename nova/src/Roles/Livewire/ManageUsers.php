<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Livewire\Component;
use Nova\Foundation\Livewire\DataTable\WithPerPagePagination;
use Nova\Foundation\Livewire\DataTable\WithSorting;
use Nova\Roles\Models\Role;

class ManageUsers extends Component
{
    use WithPerPagePagination;
    use WithSorting;

    public $listeners = [
        'usersSelected' => 'assignSelectedUsers',
    ];

    public Role $role;

    public $selected = [];

    public $selectPage = false;

    public $selectAll = false;

    /**
     * Assign the users to the role that we get from the modal.
     */
    public function assignSelectedUsers(array $users): void
    {
        $this->role->users()->attach($users);
    }

    /**
     * Unassign selected users from the role.
     */
    public function unassignSelectedUsers(): void
    {
        $this->role->users()->detach($this->selected);

        $this->selected = [];
    }

    /**
     * Select all users.
     */
    public function selectAll(): void
    {
        $this->selectAll = true;
    }

    /**
     * Set the selected users when the select page property is changed.
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
        $query = $this->role->users();

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
            'usersPage'
        );
    }

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function render()
    {
        return view('livewire.roles.manage-users', [
            'users' => $this->rows,
        ]);
    }
}
