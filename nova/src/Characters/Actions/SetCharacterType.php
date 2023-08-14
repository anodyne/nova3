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
        $character->update(['type' => match (true) {
            $character->activePrimaryUsers()->count() > 0 => CharacterType::primary,
            $character->activeUsers()->count() > 0 => CharacterType::secondary,
            default => CharacterType::support,
        }]);

        return $character->refresh();
    }
}
