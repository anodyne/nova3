<?php

namespace Nova\Departments\Livewire;

use Livewire\Component;

class PositionsCollector extends Component
{
    public $positionIds;

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
            ->filter(fn ($position) => $position['id'] !== null)
            ->implode('id', ',');
    }

    public function mount($positions = null, $character = null)
    {
        if ($positions === null) {
            $this->positions[0] = [
                'id' => null,
                'primary' => false,
            ];
        } else {
            $this->positions = collect(explode(',', $positions))
                ->map(function ($position) use ($character) {
                    return [
                        'id' => $position,
                        'primary' => ($character === null)
                            ? false
                            : $position == optional($character->primaryPosition->first())->id,
                    ];
                })
                ->toArray();

            $this->updatePositionIds();
        }
    }

    public function render()
    {
        return view('livewire.positions.collector');
    }
}
