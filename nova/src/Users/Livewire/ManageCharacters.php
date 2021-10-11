<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Foundation\Livewire\DataTable\WithBulkActions;
use Nova\Foundation\Livewire\DataTable\WithPerPagePagination;
use Nova\Foundation\Livewire\DataTable\WithSorting;
use Nova\Users\Actions\SetUserCharacters;
use Nova\Users\Actions\SetUserPrimaryCharacter;
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
        'charactersSelected' => 'assignSelectedCharacters',
    ];

    public User $user;

    /**
     * Assign the character as the user's primary character.
     */
    public function assignPrimaryCharacter(Character $character): void
    {
        SetUserPrimaryCharacter::run($this->user, $character);
    }

    /**
     * Assign the characters to the user that we get from the modal.
     */
    public function assignSelectedCharacters(array $characters): void
    {
        $charactersToSync = collect($this->user->characters()->pluck('id')->all())
            ->concat($characters)
            ->unique()
            ->all();

        SetUserCharacters::run($this->user, $charactersToSync);
    }

    /**
     * Unassign selected characters from the user.
     */
    public function unassignSelectedCharacters(): void
    {
        $charactersToSync = $this->selectAll
            ? []
            : $this->user->characters()->pluck('id')->diff($this->selected)->all();

        SetUserCharacters::run($this->user, $charactersToSync);

        $this->selected = [];
    }

    /**
     * Get the query for the rows to be displayed in the data table.
     */
    public function getRowsQueryProperty()
    {
        $query = $this->user
            ->characters()
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
            'charactersPage'
        );
    }

    public function selectAll()
    {
        $this->selectAll = true;

        $this->selected = $this->user->characters
            ->pluck('id')
            ->map(fn ($id) => (string) $id);
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
