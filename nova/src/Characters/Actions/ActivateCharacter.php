<?php

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;

class ActivateCharacter
{
    protected $setCharacterType;

    public function __construct(SetCharacterType $setCharacterType)
    {
        $this->setCharacterType = $setCharacterType;
    }

    public function execute(Character $character): Character
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($character)
            ->log(':subject.name was activated');

        $usersWithCharacterAsPrimary = $character->users()->wherePivot('primary', true)->get();

        $usersWithCharacterAsPrimary->reject(function ($user) {
            return $user->characters()->wherePivot('primary', true)->count() === 1;
        })->each(function ($user) use ($character) {
            $user->characters()->wherePivot('primary', true)->updateExistingPivot(
                $character->id,
                ['primary' => false]
            );

            $character->refresh();

            $this->setCharacterType->execute($character);
        });

        $character->status->transitionTo(Active::class);

        return $character->refresh();
    }
}
