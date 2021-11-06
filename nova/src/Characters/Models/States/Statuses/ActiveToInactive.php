<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Statuses;

use Nova\Characters\Models\Character;
use Spatie\ModelStates\Transition;

class ActiveToInactive extends Transition
{
    public function __construct(
        protected Character $character
    ) {
    }

    public function handle(): Character
    {
        $this->character->status = Inactive::class;
        $this->character->save();

        $this->character->positions->each(function ($position) {
            if (in_array($this->character->status->name(), ['primary', 'secondary', 'support'])) {
                $position->increment('available');
            }

            if ($position->pivot->primary) {
                $position->increment('available');
            }
        });

        return $this->character->refresh();
    }
}
