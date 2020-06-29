<?php

namespace Nova\Characters\Actions;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Characters\DataTransferObjects\CharacterData;

class UpdateCharacterManager
{
    protected $updateCharacter;

    protected $updateStatus;

    protected $uploadAvatar;

    protected $removeAvatar;

    public function __construct(
        UpdateCharacter $updateCharacter,
        UpdateCharacterStatus $updateStatus,
        UploadCharacterAvatar $uploadAvatar,
        RemoveCharacterAvatar $removeAvatar
    ) {
        $this->updateCharacter = $updateCharacter;
        $this->updateStatus = $updateStatus;
        $this->uploadAvatar = $uploadAvatar;
        $this->removeAvatar = $removeAvatar;
    }

    public function execute(Character $character, Request $request): Character
    {
        $this->updateCharacter->execute(
            $character,
            $data = CharacterData::fromRequest($request)
        );

        $this->updateStatus->execute($character, $request->status);

        $this->uploadAvatar->execute($character, $request->avatar_path);

        // $this->removeAvatar->execute($character, $request->input('remove_avatar', false));

        return $character->refresh();
    }
}
