<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Status;

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

        // TODO: Increment the available positions as needed

        return $this->character->refresh();
    }
}
