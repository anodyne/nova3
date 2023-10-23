<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Data\AssignUserCharactersData;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class SyncUserCharacters
{
    use AsAction;

    public function handle(User $user, AssignUserCharactersData $data): User
    {
        $characters = collect($data->characters)
            // ->mapWithKeys(function ($character) use ($data): array {
            //     $primary = (blank($data->primaryCharacter))
            //         ? ['primary' => false]
            //         : ['primary' => (int) $character === $data->primaryCharacter];

            //     return [$character => $primary];
            // })
            ->mapWithKeys(fn ($character) => [$character => ['primary' => (int) $character === $data->primaryCharacter]])
            ->all();

        $user->characters()->sync($characters);

        $this->updateCharacterTypes($data->characters);

        return $user->refresh();
    }

    protected function updateCharacterTypes(array $characterIds)
    {
        $characters = Character::whereIn('id', $characterIds)->get();

        $characters->each(fn (Character $character): Character => SetCharacterType::run($character));
    }
}
