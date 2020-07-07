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

    public function setDepartment($departmentId)
    {
        $this->departmentId = $departmentId;

        $this->positions = Position::whereDepartment($departmentId)
            ->whereActive()
            ->orderBySort()
            ->get();

        $this->dispatchBrowserEvent('show-submenu');
    }

    // public function updatedDepartmentId($value)
    // {
    //     $this->positions = Position::whereDepartment($value)
    //         ->whereActive()
    //         ->whereAvailable()
    //         ->orderBySort()
    //         ->get();
    // }

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
