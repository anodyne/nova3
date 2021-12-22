<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Models\Character;
use Nova\Users\Data\AssignUserCharactersData;
use Nova\Users\Models\User;

class AssignUserCharacters
{
    use AsAction;

    public function handle(User $user, AssignUserCharactersData $data): User
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

        $characters->each(fn ($character) => SetCharacterType::run($character));
    }
}
