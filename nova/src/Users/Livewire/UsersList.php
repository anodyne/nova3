<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Users\Models\User;

class UsersList extends Component
{
    use HasFilters;
    use WithPagination;

    public $search;

    public function filters(): array
    {
        $statusFilter = Filter::make('status')
            ->options(
                User::getStatesFor('status')
                    ->flatMap(fn ($status) => [$status => ucfirst($status)])
                    ->all()
            )
            ->default(['active'])
            ->meta(['label' => 'Status']);

        $assignedCharactersFilter = Filter::make('assigned_characters')
            ->options(['yes' => 'Yes', 'no' => 'No'])
            ->meta(['label' => 'Has assigned character(s)']);

        return [
            $statusFilter,
            $assignedCharactersFilter,
        ];
    }

    public function clearAll()
    {
        $this->reset('search');

        $this->emit('livewire-filters-reset');

        $this->dispatchBrowserEvent('close-filters-panel');
    }

    public function getFilteredUsersProperty()
    {
        return User::with('media', 'latestLogin')
            ->when($this->getFilterValue('status'), fn ($query, $values) => $query->whereIn('status', $values))
            ->when($this->getFilterValue('assigned_characters') === 'yes', fn ($query) => $query->whereHas('characters'))
            ->when($this->getFilterValue('assigned_characters') === 'no', fn ($query) => $query->doesntHave('characters'))
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->orderBy('name')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.users.users-list', [
            'activeFilterCount' => $this->activeFilterCount,
            'isFiltered' => $this->isFiltered,
            'userClass' => User::class,
            'userCount' => User::count(),
            'users' => $this->filteredUsers,
        ]);
    }
}
