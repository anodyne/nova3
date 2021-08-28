<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\DataTransferObjects\CharacterData;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;

class CreateCharacter
{
    use AsAction;

    public function handle(CharacterData $data): Character
    {
        return Character::create(array_merge(
            $data->toArray(),
            ['status' => Active::class]
        ));
    }
}
