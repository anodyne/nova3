<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;

class UploadCharacterAvatar
{
    public function execute(Character $character, $imagePath): Character
    {
        if ($imagePath !== null) {
            $character->addMedia($imagePath)->toMediaCollection('avatar');
        }

        return $character->refresh();
    }
}
