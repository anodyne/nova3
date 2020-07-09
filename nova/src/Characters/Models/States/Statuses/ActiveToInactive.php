<?php

namespace Nova\Characters\Models\States\Statuses;

use Spatie\ModelStates\Transition;
use Nova\Characters\Models\Character;

class ActiveToInactive extends Transition
{
    protected $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    public function handle(): Character
    {
        $this->character->status = Inactive::class;
        $this->character->save();

        $this->character->positions->each(function ($position) {
            if (in_array(['primary', 'secondary', 'support'], $this->character->status->name())) {
                $position->increment('available');
            }

            if ($position->pivot->primary) {
                $position->increment('available');
            }
        });

        return $this->character->refresh();
    }
}
