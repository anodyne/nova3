<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Foundation\Livewire\DataTable\WithBulkActions;
use Nova\Foundation\Livewire\DataTable\WithPerPagePagination;
use Nova\Foundation\Livewire\DataTable\WithSorting;
use Nova\Users\Models\User;

class ManageRoles extends Component
{
    use WithBulkActions;
    use WithPerPagePagination;
    use WithSorting;

    public $filters = [
        'search' => '',
    ];

    public $listeners = [
        'rolesSelected' => 'attachSelectedRoles',
    ];

    public User $user;

    /**
     * Attach the roles to the user that we get from the modal.
     */
    public function attachSelectedRoles(array $roles): void
    {
        $rolesToAttach = collect($roles)
            ->diff($this->user->roles()->pluck('id'));

        if ($rolesToAttach->count() > 0) {
            $this->user->attachRoles($roles);
        }
    }

    /**
     * Detach selected roles from the user.
     */
    public function detachSelectedRoles(): void
    {
        if ($this->selectAll) {
            $this->user->syncRoles([]);
        } else {
            $this->user->detachRoles($this->selected);
        }

        $this->selected = [];
    }

    /**
     * Get the query for the rows to be displayed in the data table.
     */
    public function getRowsQueryProperty()
    {
        $query = $this->user
            ->roles()
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
            'rolesPage'
        );
    }

    /**
     * Select all rows.
     */
    public function selectAll()
    {
        $this->selectAll = true;

        $this->selected = $this->user->roles->pluck('id')->map(fn ($id) => (string) $id);
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.users.manage-roles', [
            'roles' => $this->rows,
        ]);
    }
}
