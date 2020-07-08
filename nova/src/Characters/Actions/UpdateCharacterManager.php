<?php

namespace Nova\Characters\Actions;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Characters\DataTransferObjects\CharacterData;
use Nova\Characters\DataTransferObjects\AssignCharacterOwnersData;
use Nova\Characters\DataTransferObjects\AssignCharacterPositionsData;

class UpdateCharacterManager
{
    protected $updateCharacter;

    protected $updateStatus;

    protected $uploadAvatar;

    protected $removeAvatar;

    protected $assignCharacterOwners;

    protected $assignCharacterPositions;

    protected $setCharacterType;

    public function __construct(
        UpdateCharacter $updateCharacter,
        UpdateCharacterStatus $updateStatus,
        AssignCharacterOwners $assignCharacterOwners,
        AssignCharacterPositions $assignCharacterPositions,
        SetCharacterType $setCharacterType,
        UploadCharacterAvatar $uploadAvatar,
        RemoveCharacterAvatar $removeAvatar
    ) {
        $this->updateCharacter = $updateCharacter;
        $this->updateStatus = $updateStatus;
        $this->uploadAvatar = $uploadAvatar;
        $this->removeAvatar = $removeAvatar;
        $this->assignCharacterOwners = $assignCharacterOwners;
        $this->assignCharacterPositions = $assignCharacterPositions;
        $this->setCharacterType = $setCharacterType;
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
