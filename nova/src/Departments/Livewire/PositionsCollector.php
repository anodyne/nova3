<?php

namespace Nova\Departments\Livewire;

use Livewire\Component;

class PositionsCollector extends Component
{
    public $positions;

    public $positionIds;

    protected $listeners = ['positionSelected' => 'handlePositionSelected'];

    public function addPosition($index)
    {
        $newIndex = $index + 1;

        $this->positions[$newIndex]['id'] = null;
    }

    public function handlePositionSelected($positionId, $index)
    {
        $this->positions[$index]['id'] = $positionId;

        $this->updatePositionIds();
    }

    public function removePosition($index)
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

    public function mount($positions = null)
    {
        if ($positions === null) {
            $this->positions[0]['id'] = null;
        } else {
            $this->positions = collect(explode(',', $positions))
                ->map(function ($position) {
                    return ['id' => $position];
                })
                ->toArray();
        }
    }

    public function render()
    {
        return view('livewire.positions.collector');
    }
}
