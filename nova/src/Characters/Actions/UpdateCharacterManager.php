<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\DataTransferObjects\AssignCharacterOwnersData;
use Nova\Characters\DataTransferObjects\AssignCharacterPositionsData;
use Nova\Characters\DataTransferObjects\CharacterData;
use Nova\Characters\Models\Character;

class UpdateCharacterManager
{
    use AsAction;

    public function execute(Character $character, Request $request): Character
    {
        $character = UpdateCharacter::run(
            $character,
            CharacterData::fromRequest($request)
        );

        $character = AssignCharacterOwners::run(
            $character,
            AssignCharacterOwnersData::fromRequest($request)
        );

        $character = AssignCharacterPositions::run(
            $character,
            AssignCharacterPositionsData::fromRequest($request)
        );

        $character = SetCharacterType::run($character);

        UploadCharacterAvatar::run($character, $request->avatar_path);

        // RemoveCharacterAvatar::run($character, $request->input('remove_avatar', false));

        return $character->refresh();
    }
}
