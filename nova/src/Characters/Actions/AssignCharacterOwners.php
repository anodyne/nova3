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
        if (count($data->users) > 0) {
            collect($data->users)->each(function ($userId) use ($character, $data) {
                if ($shouldBePrimary = in_array($userId, $data->primaryCharacters)) {
                    $this->updateExistingPrimaryCharacterForUser($userId);
                }

                $character->users()->attach($userId, [
                    'primary' => $shouldBePrimary,
                ]);
            });
        }

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
