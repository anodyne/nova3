<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;

class DeleteCharacter
{
    public function execute(Character $character): Character
    {
        return tap($character)->delete();
    }
}
