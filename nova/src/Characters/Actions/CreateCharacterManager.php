<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\CreateCharacterRequest;
use Nova\Departments\Models\Position;

class CreateCharacterManager
{
    use AsAction;

    public function handle(CreateCharacterRequest $request): Character
    {
        $character = CreateCharacter::run($request->getCharacterData());

        $character = $request->user()->can('create', Character::class)
            ? $this->assignCharacterOwnersWithPermissions($character, $request)
            : $this->assignCharacterOwnersWithoutPermissions($character, $request);

        $character = AssignCharacterPositions::run(
            $character,
            $request->getCharacterPositionsData()
        );

        $character = SetCharacterType::run($character);

        // if (
        //     ($character->type === CharacterType::primary && settings()->characters->manageAvailabilityForPrimaryCharacters) ||
        //     ($character->type === CharacterType::secondary && settings()->characters->manageAvailabilityForSecondaryCharacters) ||
        //     ($character->type === CharacterType::support && settings()->characters->manageAvailabilityForSupportCharacters)
        // ) {
        //     Position::whereIn('id', $request->getCharacterPositionsData()->positions)->decrement('availability');
        // }

        UploadCharacterAvatar::run($character, $request->avatar_path);

        SendPendingCharacterNotification::run($character, $request->user());

        return $character->refresh();
    }

    protected function assignCharacterOwnersWithPermissions(
        Character $character,
        CreateCharacterRequest $request
    ): Character {
        return AssignCharacterOwners::run(
            $character,
            $request->getCharacterOwnersData()
        );
    }

    protected function assignCharacterOwnersWithoutPermissions(
        Character $character,
        CreateCharacterRequest $request
    ): Character {
        return AssignCharacterOwners::run(
            $character,
            AssignCharacterOwnersData::from([
                'users' => $request->boolean('self_assign') ? [auth()->id()] : [],
                'primaryUsers' => $request->boolean('self_primary_assign') ? [auth()->id()] : [],
            ])
        );
    }
}
