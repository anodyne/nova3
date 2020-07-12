<?php

namespace Nova\Users\Models\States;

use Nova\Users\Models\User;
use Spatie\ModelStates\Transition;
use Nova\Characters\Models\States\Statuses\Inactive as InactiveCharacter;

class ActiveToInactive extends Transition
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): User
    {
        $this->user->status = Inactive::class;

        $this->user->activeCharacters->each(function ($character) {
            if ($character->users->count() === 1) {
                $character->status->transitionTo(InactiveCharacter::class);
            }
        });

        $this->user->save();

        return $this->user;
    }
}
