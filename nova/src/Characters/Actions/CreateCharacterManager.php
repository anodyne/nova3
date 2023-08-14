<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Requests\CreateCharacterRequest;

class CreateCharacterManager
{
    use AsAction;

    public function handle(CreateCharacterRequest $request): Character
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

        UploadCharacterAvatar::run($character, $request->avatar_path);

        if ($request->user()->can('activateOnCreation', $character)) {
            $character = ActivateCharacter::run($character);
        }

        SendPendingCharacterNotification::runUnless(
            $character->status->equals(Active::class),
            $character,
            $request->user()
        );

        return $character->refresh();
    }
}
