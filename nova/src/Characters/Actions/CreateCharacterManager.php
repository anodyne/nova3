<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Http\Request;
use Nova\Characters\DataTransferObjects\AssignCharacterOwnersData;
use Nova\Characters\DataTransferObjects\AssignCharacterPositionsData;
use Nova\Characters\DataTransferObjects\CharacterData;
use Nova\Characters\Models\Character;

class CreateCharacterManager
{
    protected $assignCharacterOwners;

    protected $assignCharacterPositions;

    protected $createCharacter;

    protected $setCharacterType;

    protected $uploadCharacterAvatar;

    public function __construct(
        CreateCharacter $createCharacter,
        AssignCharacterPositions $assignCharacterPositions,
        AssignCharacterOwners $assignCharacterOwners,
        SetCharacterType $setCharacterType,
        UploadCharacterAvatar $uploadCharacterAvatar
    ) {
        $this->assignCharacterOwners = $assignCharacterOwners;
        $this->assignCharacterPositions = $assignCharacterPositions;
        $this->createCharacter = $createCharacter;
        $this->setCharacterType = $setCharacterType;
        $this->uploadCharacterAvatar = $uploadCharacterAvatar;
    }

    public function execute(Request $request): Character
    {
        $character = $this->createCharacter->execute(
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

        $this->uploadCharacterAvatar->execute($character, $request->avatar_path);

        return $character->refresh();
    }
}
