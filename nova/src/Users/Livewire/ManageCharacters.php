<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Foundation\Livewire\DataTable\WithBulkActions;
use Nova\Foundation\Livewire\DataTable\WithPerPagePagination;
use Nova\Foundation\Livewire\DataTable\WithSorting;
use Nova\Users\Models\User;

class ManageCharacters extends Component
{
    use WithBulkActions;
    use WithPerPagePagination;
    use WithSorting;

    public $filters = [
        'search' => '',
    ];

    public $listeners = [
        'charactersSelected' => 'assignedSelectedCharacters',
    ];

    public User $user;

    /**
     * Assign the characters to the user that we get from the modal.
     */
    public function assignedSelectedCharacters(array $characters): void
    {
        // $this->user->attachRoles($characters);
    }

    /**
     * Unassign selected characters from the user.
     */
    public function unassignSelectedCharacters(): void
    {
        if ($this->selectAll) {
            // $this->user->syncRoles([]);
        } else {
            // $this->user->detachRoles($this->selected);
        }

        $this->selected = [];
    }

    /**
     * Get the query for the rows to be displayed in the data table.
     */
    public function getRowsQueryProperty()
    {
        $query = $this->user
            ->characters()
            ->when($this->filters['search'], function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    return $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
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
            'charactersPage'
        );
    }

    public function selectAll()
    {
        $this->selectAll = true;

        $this->selected = $this->user->characters->pluck('id')->map(fn ($id) => (string) $id);
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.users.manage-characters', [
            'characters' => $this->rows,
        ]);
    }
}
