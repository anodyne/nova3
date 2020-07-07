<?php

namespace Nova\Departments\Livewire;

use Livewire\Component;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;

class PositionsDropdown extends Component
{
    public $departmentId;

    public $departments;

    public $positionId;

    public $positions;

    public $selected;

    public function clearPositions()
    {
        $this->positions = null;
    }

    public function selectDepartment($departmentId)
    {
        $this->departmentId = $departmentId;

        $this->positions = Position::whereDepartment($departmentId)
            ->whereActive()
            ->orderBySort()
            ->get();
    }

    public function selectPosition($positionId)
    {
        $this->positionId = $positionId;

        $this->dispatchBrowserEvent('positions-dropdown-close');

        $this->selected = $this->positions->where('id', $positionId)->first();

        $this->emit('positionSelected', $positionId);
    }

    public function mount()
    {
        $this->departmentId = null;
        $this->departments = Department::orderBySort()->get();
    }

    public function render()
    {
        return view('livewire.positions.dropdown');
    }
}
