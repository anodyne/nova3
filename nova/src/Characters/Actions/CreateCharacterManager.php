<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\DataTransferObjects\AssignCharacterOwnersData;
use Nova\Characters\DataTransferObjects\AssignCharacterPositionsData;
use Nova\Characters\DataTransferObjects\CharacterData;
use Nova\Characters\Models\Character;

class CreateCharacterManager
{
    use AsAction;

    public function handle(Request $request): Character
    {
        $character = CreateCharacter::run(
            CharacterData::fromRequest($request)
        );

        if ($request->self_assign) {
            $character = SelfAssignCharacter::run($character);
        } else {
            $character = AssignCharacterOwners::run(
                $character,
                AssignCharacterOwnersData::fromRequest($request)
            );
        }

        $character = AssignCharacterPositions::run(
            $character,
            AssignCharacterPositionsData::fromRequest($request)
        );

        $character = SetCharacterType::run($character);

        UploadCharacterAvatar::run($character, $request->avatar_path);

        SendPendingCharacterNotification::run($character);

        return $character->refresh();
    }
}
