<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Livewire\Component;
use Nova\Foundation\Livewire\DataTable\WithBulkActions;
use Nova\Foundation\Livewire\DataTable\WithPerPagePagination;
use Nova\Foundation\Livewire\DataTable\WithSorting;
use Nova\Roles\Models\Role;
use Nova\Stories\Models\Story;

class PostsList extends Component
{
    use WithBulkActions;
    use WithPerPagePagination;
    use WithSorting;

    public $filters = [
        'search' => '',
        'types' => [],
    ];

    public $listeners = [
        'permissionsSelected' => 'attachSelectedPermissions',
    ];

    public Story $story;

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
        $query = $this->story
            ->posts()
            ->hasParent()
            ->when($this->filters['search'], fn ($query, $search) => $query->searchFor($search))
            ->when($this->filters['types'], fn ($query, $types) => $query->whereIn('type', $types))
            ->defaultOrder();

        return $this->applySorting($query);
    }

    /**
     * Get the paginated rows to be displayed in the data table.
     */
    public function getRowsProperty()
    {
        return $this->applyPagination(
            $this->rowsQuery,
            $this->columns
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

    public function mount(Story $story)
    {
        $this->story = $story;
    }

    public function render()
    {
        return view('livewire.stories.posts-list', [
            'posts' => $this->rows,
        ]);
    }
}
