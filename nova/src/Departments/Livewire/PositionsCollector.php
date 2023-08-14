<?php

declare(strict_types=1);

namespace Nova\Departments\Livewire;

use Livewire\Component;

class PositionsCollector extends Component
{
    public $positions;

    protected $listeners = ['positionSelected' => 'handlePositionSelected'];

    public function addPosition($index)
    {
        $newIndex = $index + 1;

        $this->positions[$newIndex] = [
            'id' => null,
            'primary' => false,
        ];
    }

    public function handlePositionSelected($positionId, $index)
    {
        $this->positions[$index] = [
            'id' => $positionId,
            'primary' => false,
        ];
    }

    public function removePosition($index)
    {
        unset($this->positions[$index]);

        $this->positions = array_values($this->positions);
    }

    public function mount($positions = null, $character = null)
    {
        if ($positions === null || (is_array($positions) && count($positions) === 0)) {
            $this->positions[0] = [
                'id' => null,
            ];
        } else {
            $this->positions = collect($positions)
                ->map(fn ($position) => ['id' => $position])
                ->toArray();
        }
    }

    public function render()
    {
        return view('livewire.positions.collector');
    }
}
