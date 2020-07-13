<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Nova\Characters\Models\Character;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Users\DataTransferObjects\AssignUserCharactersData;

class AssignUserCharacters
{
    protected $setCharacterType;

    public function __construct(SetCharacterType $setCharacterType)
    {
        $this->setCharacterType = $setCharacterType;
    }

    public function execute(User $user, AssignUserCharactersData $data): User
    {
        $characters = collect($data->characters)
            ->mapWithKeys(function ($character) use ($data) {
                $primary = (! isset($data->primaryCharacter))
                    ? ['primary' => false]
                    : ['primary' => (int) $character === $data->primaryCharacter->id];

                return [$character => $primary];
            })
            ->all();

        $user->characters()->sync($characters);

        $this->updateCharacterTypes($data->characters);

        return $user->refresh();
    }

    protected function updateCharacterTypes(array $characterIds)
    {
        $characters = Character::whereIn('id', $characterIds)->get();

        $characters->each(function ($character) {
            $this->setCharacterType->execute($character);
        });
    }
}
