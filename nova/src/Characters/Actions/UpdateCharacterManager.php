<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\UpdateCharacterRequest;
use Nova\Departments\Actions\AutoAvailabilityManager;

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

        AutoAvailabilityManager::runIf(
            match (true) {
                $character->type === CharacterType::primary && settings('characters.autoAvailabilityForPrimary') => true,
                $character->type === CharacterType::secondary && settings('characters.autoAvailabilityForSecondary') => true,
                $character->type === CharacterType::support && settings('characters.autoAvailabilityForSupport') => true,
                default => false,
            },
            $character,
            $request->getCharacterPositionsData(),
            $oldPositionIds
        );

        UploadCharacterAvatar::run($character, $request->avatar_path);

        // RemoveCharacterAvatar::run($character, $request->input('remove_avatar', false));

        return $character->refresh();
    }
}
