<?php

declare(strict_types=1);

namespace Nova\Users\Models\States\Status;

use Nova\Characters\Models\States\Status\Inactive as InactiveCharacter;
use Nova\Foundation\Actions\TrackStatusUpdate;
use Nova\Users\Models\User;
use Spatie\ModelStates\Transition;

class ActiveToInactive extends Transition
{
    public function __construct(
        protected User $user
    ) {}

    public function handle(): User
    {
        $this->user->loadMissing('activeCharacters.users');

        $this->user->status = new Inactive($this->user);

        $this->user->activeCharacters->each(function ($character) {
            if ($character->users->count() === 1) {
                $character->status->transitionTo(InactiveCharacter::class);
            }
        });

        $this->user->save();

        $this->user->syncRoles([]);

        TrackStatusUpdate::run($this->user);

        return $this->user;
    }
}
