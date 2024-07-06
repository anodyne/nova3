<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Status;

use Nova\Characters\Models\Character;
use Spatie\ModelStates\Transition;

class InactiveToActive extends Transition
{
    public function __construct(
        protected Character $character
    ) {}

    public function handle(): Character
    {
        $this->character->status = Active::class;
        $this->character->save();

        // TODO: Decrement the available positions as needed

        // TODO: Cleanup primary character

        return $this->character->refresh();
    }
}
