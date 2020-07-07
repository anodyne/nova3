<?php

namespace Nova\Departments\Livewire;

use Livewire\Component;

class PositionsCollector extends Component
{
    public $positions = [];

    public $positionIds;

    protected $listeners = ['positionSelected'];

    public function addPosition($id = null): void
    {
        $this->positions[] = [
            'id' => $id,
        ];
    }

    public function positionSelected($positionId)
    {
        $this->addPosition($positionId);
    }

    public function removePosition($index): void
    {
        unset($this->positions[$index]);
    }

    public function updatedPositions()
    {
        $this->positionIds = collect($this->positions);
        dd($this->positionIds);

        // $this->positionIds = implode(',', array_map(function ($value) {
        //     return $value['id'];
        // }, $this->positions));
    }

    public function mount()
    {
        $this->addPosition();
    }

    public function render()
    {
        return view('livewire.positions.collector');
    }
}
