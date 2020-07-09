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

        $character->users()->sync($users);

        return $character->refresh();
    }

    protected function updateExistingPrimaryCharacterForUser($userId)
    {
        $user = User::find($userId);

        $oldPrimaryCharacter = $user->primaryCharacter->first();

        if ($oldPrimaryCharacter) {
            $user->primaryCharacter()->updateExistingPivot(
                $oldPrimaryCharacter->id,
                ['primary' => false]
            );

            $this->setCharacterType->execute($oldPrimaryCharacter);
        }
    }
}
