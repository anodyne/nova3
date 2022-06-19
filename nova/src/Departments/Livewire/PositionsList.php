<?php

declare(strict_types=1);

namespace Nova\Departments\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Departments\Actions\ReorderPositions;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Livewire\CanReorder;

class PositionsList extends Component
{
    use AuthorizesRequests;
    use CanReorder;
    use HasFilters;
    use WithPagination;

    public $search;

    public function filters(): array
    {
        $statusFilter = Filter::make('status')
            ->options(
                Position::getStatesFor('status')
                    ->flatMap(fn ($status) => [$status => ucfirst($status)])
                    ->all()
            )
            ->default(['active', 'inactive'])
            ->meta(['label' => 'Status']);

        $availableCountFilter = Filter::make('available_count')
            ->options([
                'none' => 'None',
                'one' => 'One',
                'multiple' => 'More than one',
            ])
            ->meta(['label' => 'Available slots']);

        $assignedCharacterFilter = Filter::make('assigned_character')
            ->options([
                'yes' => 'Yes',
                'no' => 'No',
            ])
            ->meta(['label' => 'Has assigned character(s)']);

        $departmentsFilter = Filter::make('department')
            ->options(Department::orderBySort()->pluck('name', 'id')->all())
            ->value(request('department', ''))
            ->meta(['label' => 'Department']);

        return [
            $statusFilter,
            $availableCountFilter,
            $assignedCharacterFilter,
            $departmentsFilter,
        ];
    }

    public function clearAll()
    {
        $this->reset('search');

        $this->emit('livewire-filters-reset');

        $this->dispatchBrowserEvent('close-filters-panel');
    }

    public function getFilteredPositionsProperty()
    {
        $positions = Position::withCount('activeCharacters')
            ->when($this->getFilterValue('status'), fn ($query, $values) => $query->whereIn('status', $values))
            ->when($this->getFilterValue('available_count'), function ($query, $value) {
                return match ($value) {
                    default => $query->where('available', 0),
                    'one' => $query->where('available', 1),
                    'multiple' => $query->where('available', '>=', 2),
                };
            })
            ->when($this->getFilterValue('assigned_character'), function ($query, $value) {
                return match ($value) {
                    default => $query->has('characters'),
                    'no' => $query->doesntHave('characters'),
                };
            })
            ->when($this->getFilterValue('department'), fn ($query, $value) => $query->whereDepartment($value))
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->orderBySort();

        if ($this->reordering) {
            return $positions->get();
        }

        return $positions->paginate();
    }

    public function reorder(array $items): void
    {
        $this->authorize('update', new Position());

        ReorderPositions::run($items);
    }

    public function render()
    {
        return view('livewire.positions.positions-list', [
            'activeFilterCount' => $this->activeFilterCount,
            'isFiltered' => $this->isFiltered,
            'positions' => $this->filteredPositions,
        ]);
    }
}
