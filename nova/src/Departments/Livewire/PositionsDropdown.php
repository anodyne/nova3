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

    public $index;

    protected $listeners = ['refresh-positions-dropdown' => '$refresh'];

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

        $this->emitUp('positionSelected', $positionId, $this->index);
    }

    public function mount($position = null, $index = 0)
    {
        $this->index = $index;
        $this->positionId = $position;
        $this->departmentId = null;
        $this->departments = Department::orderBySort()->get();

        if ($position) {
            $this->selected = Position::find($position);
        }
    }

    public function render()
    {
        return view('livewire.positions.dropdown');
    }
}
