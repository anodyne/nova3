<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Data\CharacterData;
use Nova\Characters\Models\Character;

class UpdateCharacterManager
{
    use AsAction;

    public function handle(Character $character, Request $request): Character
    {
        $character = UpdateCharacter::run(
            $character,
            CharacterData::from($request)
        );

        $character = AssignCharacterOwners::run(
            $character,
            AssignCharacterOwnersData::from($request)
        );

        $character = AssignCharacterPositions::run(
            $character,
            AssignCharacterPositionsData::from($request)
        );

        $character = SetCharacterType::run($character);

        UploadCharacterAvatar::run($character, $request->avatar_path);

        // RemoveCharacterAvatar::run($character, $request->input('remove_avatar', false));

        return $character->refresh();
    }
}
