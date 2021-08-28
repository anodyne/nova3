<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\DataTransferObjects\AssignCharacterOwnersData;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class AssignCharacterOwners
{
    use AsAction;

    public function handle(
        Character $character,
        AssignCharacterOwnersData $data
    ): Character {
        $users = collect($data->users)
            ->mapWithKeys(function ($user) use ($data) {
                $primary = (! isset($data->primaryCharacters))
                    ? ['primary' => false]
                    : ['primary' => in_array($user, $data->primaryCharacters)];

                return [$user => $primary];
            })
            ->all();

        $this->updateExistingPrimaryCharacterForUsers($character, $data);

        $character->users()->sync($users);

        return $character->refresh();
    }

    protected function updateExistingPrimaryCharacterForUsers(
        Character $character,
        AssignCharacterOwnersData $data
    ): void {
        collect($data->primaryCharacters)->each(function ($userId) use ($character) {
            $user = User::find($userId);

            $oldPrimaryCharacter = $user->primaryCharacter->first();

            if ($oldPrimaryCharacter && $oldPrimaryCharacter->isNot($character)) {
                $user->primaryCharacter()->updateExistingPivot(
                    $oldPrimaryCharacter->id,
                    ['primary' => false]
                );

                SetCharacterType::run($oldPrimaryCharacter);
            }
        });
    }
}
