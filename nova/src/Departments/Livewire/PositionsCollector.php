<?php

namespace Nova\Departments\Livewire;

use Livewire\Component;

class PositionsCollector extends Component
{
    public $positions;

    public $positionIds;

    protected $listeners = ['positionSelected'];

    public function addPosition($index): void
    {
        $newIndex = $index + 1;

        $this->positions[$newIndex]['id'] = null;
    }

    public function positionSelected($positionId, $index)
    {
        $this->positions[$index]['id'] = $positionId;

        $this->updatePositionIds();
    }

    public function removePosition($index): void
    {
        unset($this->positions[$index]);

        $this->positions = array_values($this->positions);

        $this->updatePositionIds();
    }

    public function updatePositionIds()
    {
        $this->positionIds = collect($this->positions)
            ->filter(function ($position) {
                return $position['id'] !== null;
            })
            ->implode('id', ',');
    }

    public function mount()
    {
        $this->positions[0]['id'] = null;
    }

    public function render()
    {
        return view('livewire.positions.collector');
    }
}
