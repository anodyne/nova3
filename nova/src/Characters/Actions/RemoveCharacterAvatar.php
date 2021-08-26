<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;

class RemoveCharacterAvatar
{
    public function execute(Character $character, bool $removeAvatar = false): Character
    {
        if ($removeAvatar) {
            $character->clearMediaCollection('avatar');
        }

        return $character->refresh();
    }
}
