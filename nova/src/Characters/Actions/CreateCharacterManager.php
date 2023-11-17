<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\CharacterPositionsData;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\StoreCharacterRequest;
use Nova\Departments\Actions\UpdatePositionAvailability;

class CreateCharacterManager
{
    use AsAction;

    public function handle(StoreCharacterRequest $request): Character
    {
        $character = CreateCharacter::run($request->getCharacterData());

        $character = AssignCharacterPositions::run(
            $character,
            $request->getCharacterPositionsData()
        );

        if ($request->user()->can('create', Character::class)) {
            $character = AssignCharacterOwners::run(
                $character,
                $request->getCharacterOwnersData()
            );
        } else {
            AssignCharacterOwners::run(
                $character,
                $request->getAutoLinkedCharacterOwnersData()
            );
        }

        $character = SetCharacterType::run($character);

        $positions = new CharacterPositionsData(
            character: $character,
            currentType: $character->type,
            currentPositions: $character->positions
        );

        UpdatePositionAvailability::run($positions);

        UploadCharacterAvatar::run($character, $request->avatar_path);

        if ($request->user()->can('activateOnCreation', $character)) {
            $character = ActivateCharacter::run($character);
        }

        SendPendingCharacterNotification::runUnless(
            $character->is_active,
            $character,
            $request->user()
        );

        return $character->refresh();
    }
}
