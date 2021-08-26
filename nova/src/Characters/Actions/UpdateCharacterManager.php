<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Http\Request;
use Nova\Characters\DataTransferObjects\AssignCharacterOwnersData;
use Nova\Characters\DataTransferObjects\AssignCharacterPositionsData;
use Nova\Characters\DataTransferObjects\CharacterData;
use Nova\Characters\Models\Character;

class UpdateCharacterManager
{
    protected $assignCharacterOwners;

    protected $assignCharacterPositions;

    protected $removeAvatar;

    protected $setCharacterType;

    protected $updateCharacter;

    protected $updateStatus;

    protected $uploadAvatar;

    public function __construct(
        AssignCharacterOwners $assignCharacterOwners,
        AssignCharacterPositions $assignCharacterPositions,
        RemoveCharacterAvatar $removeAvatar,
        SetCharacterType $setCharacterType,
        UpdateCharacter $updateCharacter,
        UpdateCharacterStatus $updateStatus,
        UploadCharacterAvatar $uploadAvatar
    ) {
        $this->assignCharacterOwners = $assignCharacterOwners;
        $this->assignCharacterPositions = $assignCharacterPositions;
        $this->removeAvatar = $removeAvatar;
        $this->setCharacterType = $setCharacterType;
        $this->updateCharacter = $updateCharacter;
        $this->updateStatus = $updateStatus;
        $this->uploadAvatar = $uploadAvatar;
    }

    public function execute(Character $character, Request $request): Character
    {
        $character = $this->updateCharacter->execute(
            $character,
            CharacterData::fromRequest($request)
        );

        $character = $this->assignCharacterOwners->execute(
            $character,
            AssignCharacterOwnersData::fromRequest($request)
        );

        $character = $this->assignCharacterPositions->execute(
            $character,
            AssignCharacterPositionsData::fromRequest($request)
        );

        $character = $this->setCharacterType->execute($character);

        $this->uploadAvatar->execute($character, $request->avatar_path);

        // $this->removeAvatar->execute($character, $request->input('remove_avatar', false));

        return $character->refresh();
    }
}
