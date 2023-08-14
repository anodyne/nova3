<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Models\Character;

class AssignCharacterOwners
{
    use AsAction;

    public function handle(Character $character, AssignCharacterOwnersData $data): Character
    {
        $users = collect($data->users)
            ->filter()
            ->mapWithKeys(function ($user) use ($data) {
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
