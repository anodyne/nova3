<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Characters\Models\Character;

class CharactersList extends Component
{
    use HasFilters;
    use WithPagination;

    public $search;

    public function filters(): array
    {
        $statusFilter = Filter::make('status')
            ->options(
                Character::getStatesFor('status')
                    ->flatMap(fn ($status) => [$status => ucfirst($status)])
                    ->all()
            )
            ->default(['active'])
            ->meta(['label' => 'Status']);

        $typeFilter = Filter::make('type')
            ->options(
                Character::getStatesFor('type')
                    ->flatMap(fn ($type) => [$type => ucfirst($type)])
                    ->all()
            )
            ->default(['primary', 'secondary', 'support'])
            ->meta(['label' => 'Type']);

        $assignedUsersFilter = Filter::make('assigned_users')
            ->options(['yes' => 'Yes', 'no' => 'No'])
            ->meta(['label' => 'Has assigned user(s)']);

        $assignedPositionsFilter = Filter::make('assigned_positions')
            ->options(['yes' => 'Yes', 'no' => 'No'])
            ->meta(['label' => 'Has assigned position(s)']);

        $myCharactersFilter = Filter::make('my_characters')
            ->options(['yes' => 'Yes'])
            ->meta(['label' => 'Only show my character(s)']);

        $filters = [
            $typeFilter,
            $statusFilter,
            $assignedUsersFilter,
            $assignedPositionsFilter,
        ];

        if (auth()->user()->can('viewAny', Character::class)) {
            $filters[] = $myCharactersFilter;
        }

        return $filters;
    }

    public function clearAll()
    {
        $this->reset('search');

        $this->emit('livewire-filters-reset');

        $this->dispatchBrowserEvent('close-filters-panel');
    }

    public function getFilteredCharactersProperty()
    {
        return Character::with('media', 'positions', 'rank.name', 'users')
            ->when(
                auth()->user()->cannot('viewAny', Character::class),
                fn ($query) => $query->whereRelation('users', 'users.id', '=', auth()->id())
            )
            ->when(
                $this->getFilterValue('my_characters') === 'yes',
                fn ($query) => $query->whereRelation('users', 'users.id', '=', auth()->id())
            )
            ->when($this->getFilterValue('status'), fn ($query, $values) => $query->whereIn('status', $values))
            ->when($this->getFilterValue('type'), fn ($query, $values) => $query->whereIn('type', $values))
            ->when($this->getFilterValue('assigned_users') === 'yes', fn ($query) => $query->whereHas('users'))
            ->when($this->getFilterValue('assigned_users') === 'no', fn ($query) => $query->doesntHave('users'))
            ->when($this->getFilterValue('assigned_positions') === 'yes', fn ($query) => $query->whereHas('positions'))
            ->when($this->getFilterValue('assigned_positions') === 'no', fn ($query) => $query->doesntHave('positions'))
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->orderBy('name')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.characters.characters-list', [
            'activeFilterCount' => $this->activeFilterCount,
            'isFiltered' => $this->isFiltered,
            'characters' => $this->filteredCharacters,
        ]);
    }
}
