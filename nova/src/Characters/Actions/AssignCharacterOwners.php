<?php

namespace Nova\Characters\Actions;

use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Nova\Characters\DataTransferObjects\AssignCharacterOwnersData;

class AssignCharacterOwners
{
    protected $setCharacterType;

    public function __construct(SetCharacterType $setCharacterType)
    {
        $this->setCharacterType = $setCharacterType;
    }

    public function execute(Character $character, AssignCharacterOwnersData $data): Character
    {
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
    ) {
        collect($data->primaryCharacters)->each(function ($userId) use ($character) {
            $user = User::find($userId);

            $oldPrimaryCharacter = $user->primaryCharacter->first();

            if ($oldPrimaryCharacter && $oldPrimaryCharacter->isNot($character)) {
                $user->primaryCharacter()->updateExistingPivot(
                    $oldPrimaryCharacter->id,
                    ['primary' => false]
                );

                $this->setCharacterType->execute($oldPrimaryCharacter);
            }
        });
    }
}
