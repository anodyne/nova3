<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;

class SetCharacterType
{
    use AsAction;

    public function handle(Character $character): Character
    {
        if ($character->activeUsers()->count() > 0) {
            $character->update(['type' => CharacterType::secondary]);
        }

        $character->refresh();

        if ($character->primaryUsers()->count() > 0) {
            $character->update(['type' => CharacterType::primary]);
        }

        return $character->refresh();
    }
}
