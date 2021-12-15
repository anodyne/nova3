<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;

class ActivateCharacter
{
    use AsAction;

    public function handle(Character $character): Character
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

            SetCharacterType::run($character);
        });

        $character->status->transitionTo(Active::class);

        return $character->refresh();
    }
}
