<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;

class ForceDeleteCharacter extends Action
{
    public function handle(Character $character): Character
    {
        return tap($character)->forceDelete();
    }
}
