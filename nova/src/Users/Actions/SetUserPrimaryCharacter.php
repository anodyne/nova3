<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class SetUserPrimaryCharacter
{
    use AsAction;

    public function handle(User $user, Character $character): User
    {
        $user->characters()->updateExistingPivot($user->primaryCharacter->first()->id, [
            'primary' => false,
        ]);

        $user->characters()->updateExistingPivot($character->id, [
            'primary' => true,
        ]);

        $this->updateCharacterTypes($user->characters);

        return $user->refresh();
    }

    protected function updateCharacterTypes(Collection $characters): void
    {
        $characters->each(fn ($character) => SetCharacterType::run($character));
    }
}
