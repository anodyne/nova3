<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\UpdateCharacterRequest;
use Nova\Departments\Models\Position;

class UpdateCharacterManager
{
    use AsAction;

    public function handle(
        Character $character,
        UpdateCharacterRequest $request
    ): Character {
        $oldPositionIds = $character->positions()->pluck('position_id')->all();
        ray($oldPositionIds);

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

        // if ($character->type === CharacterType::primary && settings()->characters->manageAvailabilityForPrimaryCharacters) {
        //     Position::whereIn(
        //         'id',
        //         array_diff($request->getCharacterPositionsData()->positions, $oldPositionIds)
        //     )->decrement('available');

        //     Position::whereIn(
        //         'id',
        //         array_diff($oldPositionIds, $request->getCharacterPositionsData()->positions)
        //     )->increment('available');
        // }

        UploadCharacterAvatar::run($character, $request->avatar_path);

        // RemoveCharacterAvatar::run($character, $request->input('remove_avatar', false));

        return $character->refresh();
    }
}
