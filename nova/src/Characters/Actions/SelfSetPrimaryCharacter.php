<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;

class SelfSetPrimaryCharacter
{
    use AsAction;

    public function handle(Character $character): Character
    {
        if (settings()->characters->allowSettingPrimaryCharacter) {
            if ($character->isAssignedTo($user = auth()->user())->count() > 0) {
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($character)
                    ->log(':subject.name was self-assigned as the primary character of :causer.name');

                $character->users()->sync([$user->id => ['primary' => true]]);
            }
        }

        return $character->refresh();
    }
}
