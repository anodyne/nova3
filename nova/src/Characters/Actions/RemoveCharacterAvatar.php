<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;

class RemoveCharacterAvatar
{
    use AsAction;

    public function handle(Character $character, bool $removeAvatar = false): Character
    {
        if ($removeAvatar) {
            $character->clearMediaCollection('avatar');
        }

        return $character->refresh();
    }
}
