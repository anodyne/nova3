<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Foundation\Livewire\DataTable\WithBulkActions;
use Nova\Foundation\Livewire\DataTable\WithPerPagePagination;
use Nova\Foundation\Livewire\DataTable\WithSorting;
use Nova\Users\Actions\SetUserRoles;
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
        $rolesToSync = collect($this->user->roles()->pluck('id')->all())
            ->concat($roles)
            ->unique()
            ->all();

        SetUserRoles::run($this->user, $rolesToSync);
    }

    /**
     * Detach selected roles from the user.
     */
    public function detachSelectedRoles(): void
    {
        $rolesToSync = $this->selectAll
            ? []
            : $this->user->roles()->pluck('id')->diff($this->selected)->all();

        SetUserRoles::run($this->user, $rolesToSync);

        $this->selected = [];
    }

    /**
     * Get the query for the rows to be displayed in the data table.
     */
    public function getRowsQueryProperty()
    {
        $query = $this->user
            ->roles()
            ->when(
                $this->filters['search'],
                fn ($query, $search) => $query->searchFor($search)
            );

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

        $this->selected = $this->user->roles
            ->pluck('id')
            ->map(fn ($id) => (string) $id);
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
