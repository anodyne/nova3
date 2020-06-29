<?php

namespace Nova\Characters\Actions;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Characters\DataTransferObjects\CharacterData;

class CreateCharacterManager
{
    protected $createCharacter;

    protected $uploadCharacterAvatar;

    public function __construct(
        CreateCharacter $createCharacter,
        UploadCharacterAvatar $uploadCharacterAvatar
    ) {
        $this->createCharacter = $createCharacter;
        $this->uploadCharacterAvatar = $uploadCharacterAvatar;
    }

    public function execute(Request $request): Character
    {
        $character = $this->createCharacter->execute(
            CharacterData::fromRequest($request)
        );

        $this->uploadCharacterAvatar->execute($character, $request->avatar_path);

        return $character->fresh();
    }
}
