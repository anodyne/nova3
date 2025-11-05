<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Status;

use Nova\Characters\Data\CharacterPositionsData;
use Nova\Characters\Models\Character;
use Nova\Departments\Actions\UpdatePositionAvailability;
use Nova\Foundation\Actions\TrackStatusUpdate;
use Spatie\ModelStates\Transition;

class ActiveToInactive extends Transition
{
    public function __construct(
        protected Character $character
    ) {}

    public function handle(): Character
    {
        $this->character->status = Inactive::class;
        $this->character->save();

        TrackStatusUpdate::run($this->character);

        $this->updatePositionAvailability();

        return $this->character->refresh();
    }

    protected function updatePositionAvailability(): void
    {
        UpdatePositionAvailability::run(CharacterPositionsData::from(
            character: $this->character,
            oldType: $this->character->type,
            newType: $this->character->type,
            oldPositions: $this->character->positions,
            newPositions: $this->character->positions,
            oldStatus: Active::$name,
            newStatus: Inactive::$name
        ));
    }
}
