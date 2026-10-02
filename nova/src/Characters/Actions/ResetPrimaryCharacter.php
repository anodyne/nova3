<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;
use Nova\Users\Models\User;

class ResetPrimaryCharacter extends Action
{
    public function handle(Character $character, AssignCharacterOwnersData $data): Character
    {
        collect($data->primaryUsers)
            ->filter()
            ->each(function ($userId) use ($character): void {
                $user = User::find($userId);

                $oldPrimaryCharacter = $user?->primaryCharacter->first();

                if ($oldPrimaryCharacter && $oldPrimaryCharacter->isNot($character)) {
                    $user->primaryCharacter()->updateExistingPivot(
                        $oldPrimaryCharacter->id,
                        ['primary' => false]
                    );

                    $oldPrimaryCharacter->refresh();

                    SetCharacterType::run($oldPrimaryCharacter);
                }
            });

        return $character->refresh();
    }
}
