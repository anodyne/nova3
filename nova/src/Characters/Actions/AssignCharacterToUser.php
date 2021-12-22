<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class AssignCharacterToUser
{
    use AsAction;

    public function handle(Character $character, User $user, bool $primary = false): Character
    {
        $character->users()->syncWithoutDetaching([$user->id => ['primary' => $primary]]);

        return $character->refresh();
    }
}
