<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;

class SelfAssignCharacter
{
    use AsAction;

    public function handle(Character $character): Character
    {
        $character->users()->sync([auth()->id()]);

        return $character->refresh();
    }
}