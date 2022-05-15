<?php

declare(strict_types=1);

namespace Nova\Departments\Livewire;

use Livewire\Component;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

class PositionsDropdown extends Component
{
    public $departments;

    public $index;

    public $positions;

    public $selected;

    public function clearPositions()
    {
        $this->reset('positions');
    }

    public function selectDepartment($departmentId)
    {
        $this->positions = Position::query()
            ->whereDepartment($departmentId)
            ->whereActive()
            ->orderBySort()
            ->get();
    }

    public function selectPosition($positionId)
    {
        $this->dispatchBrowserEvent('positions-dropdown-close');

        $this->selected = $this->positions->where('id', $positionId)->first();

        $this->emitUp('positionSelected', $positionId, $this->index);
    }

    public function mount($position = null, $index = 0)
    {
        $this->index = $index;
        $this->departments = Department::orderBySort()->get();

        if ($position) {
            $this->selected = Position::find($position);

            $this->selectDepartment($this->selected->department_id);
        }
    }

    public function render()
    {
        return view('livewire.positions.dropdown');
    }
}
