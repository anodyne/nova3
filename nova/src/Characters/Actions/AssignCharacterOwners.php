<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;

class AssignCharacterOwners extends Action
{
    public function handle(Character $character, AssignCharacterOwnersData $data): Character
    {
        $users = collect($data->users)
            ->filter()
            ->mapWithKeys(function ($user) use ($data): array {
                $primary = (! isset($data->primaryUsers))
                    ? ['primary' => false]
                    : ['primary' => in_array($user, $data->primaryUsers)];

                return [$user => $primary];
            })
            ->all();

        $character->users()->sync($users);

        return $character->refresh();
    }
}
