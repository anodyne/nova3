<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Actions\SetCharacterType;
use Nova\Characters\Models\Character;
use Nova\Users\Data\AssignUserCharactersData;
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
            ->mapWithKeys(fn ($character): array => [$character => ['primary' => (int) $character === $data->primaryCharacter]])
            ->all();

        $operations = $user->characters()->sync($characters);

        if (count($operations['attached']) > 0) {
            activity()
                ->performedOn($user)
                ->withProperties([
                    'characterIds' => $operations['attached'],
                ])
                ->event('assigned')
                ->log('assigned');
        }

        if (count($operations['detached']) > 0) {
            activity()
                ->performedOn($user)
                ->withProperties([
                    'characterIds' => $operations['detached'],
                ])
                ->event('unassigned')
                ->log('unassigned');
        }

        $this->updateCharacterTypes($data->characters);

        return $user->refresh();
    }

    /** @param list<string> $characterIds */
    protected function updateCharacterTypes(array $characterIds): void
    {
        $characters = Character::whereIn('id', $characterIds)->get();

        $characters->each(fn (Character $character): Character => SetCharacterType::run($character));
    }
}
