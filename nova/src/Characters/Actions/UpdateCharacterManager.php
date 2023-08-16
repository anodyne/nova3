<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\CharacterPositionsData;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\UpdateCharacterRequest;
use Nova\Departments\Actions\UpdatePositionAvailability;

class UpdateCharacterManager
{
    use AsAction;

    public function handle(
        Character $character,
        UpdateCharacterRequest $request
    ): Character {
        $positions = new CharacterPositionsData(
            character: $character,
            previousType: $character->type,
            previousPositions: $character->positions
        );

        $character = UpdateCharacter::run(
            $character,
            $request->getCharacterData()
        );

        $character = AssignCharacterPositions::run(
            $character,
            $request->getCharacterPositionsData()
        );

        $character = AssignCharacterOwners::run(
            $character,
            $request->getCharacterOwnersData()
        );

        $character = SetCharacterType::run($character);

        $positions->currentType = $character->type;
        $positions->currentPositions = $character->positions;

        UpdatePositionAvailability::run($positions);

        UploadCharacterAvatar::run($character, $request->avatar_path);

        // RemoveCharacterAvatar::run($character, $request->input('remove_avatar', false));

        return $character->refresh();
    }
}
