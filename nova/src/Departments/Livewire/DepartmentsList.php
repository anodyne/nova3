<?php

declare(strict_types=1);

namespace Nova\Departments\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Departments\Actions\ReorderDepartments;
use Nova\Departments\Models\Department;
use Nova\Foundation\Livewire\CanReorder;

class DepartmentsList extends Component
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
                Department::getStatesFor('status')
                    ->flatMap(fn ($status) => [$status => ucfirst($status)])
                    ->all()
            )
            ->default(['active', 'inactive'])
            ->meta(['label' => 'Status']);

        return [
            $statusFilter,
        ];
    }

    public function clearAll()
    {
        $this->reset('search');

        $this->emit('livewire-filters-reset');

        $this->dispatchBrowserEvent('close-filters-panel');
    }

    public function getFilteredDepartmentsProperty()
    {
        $departments = Department::withCount('positions')
            ->when($this->getFilterValue('status'), fn ($query, $values) => $query->whereIn('status', $values))
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->orderBySort();

        if ($this->reordering) {
            return $departments->get();
        }

        return $departments->paginate();
    }

    public function reorder(array $items): void
    {
        $this->authorize('update', new Department());

        ReorderDepartments::run($items);
    }

    public function render()
    {
        return view('livewire.departments.departments-list', [
            'activeFilterCount' => $this->activeFilterCount,
            'isFiltered' => $this->isFiltered,
            'departments' => $this->filteredDepartments,
        ]);
    }
}
