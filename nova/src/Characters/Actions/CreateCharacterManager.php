<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Data\CharacterData;
use Nova\Characters\Models\Character;

class CreateCharacterManager
{
    use AsAction;

    public function handle(Request $request): Character
    {
        $character = CreateCharacter::run(CharacterData::from($request));

        $character = $request->user()->can('create', Character::class)
            ? $this->assignCharacterOwnersWithPermissions($character, $request)
            : $this->assignCharacterOwnersWithoutPermissions($character, $request);

        $character = AssignCharacterPositions::run(
            $character,
            AssignCharacterPositionsData::from($request)
        );

        $character = SetCharacterType::run($character);

        UploadCharacterAvatar::run($character, $request->avatar_path);

        if ($request->user()->cannot('create', Character::class)) {
            // SendPendingCharacterNotification::run($character, auth()->user());
        }

        return $character->refresh();
    }

    protected function assignCharacterOwnersWithPermissions(
        Character $character,
        Request $request
    ): Character {
        return AssignCharacterOwners::run(
            $character,
            AssignCharacterOwnersData::from($request)
        );
    }

    protected function assignCharacterOwnersWithoutPermissions(
        Character $character,
        Request $request
    ): Character {
        return AssignCharacterOwners::run(
            $character,
            AssignCharacterOwnersData::from([
                'users' => (bool) $request->self_assign ? [auth()->id()] : '',
                'primaryCharacters' => (bool) $request->self_primary_assign ? [auth()->id()] : [],
            ])
        );
    }
}
