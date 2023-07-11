<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\CharacterData;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Pending;

class CreateCharacter
{
    use AsAction;

    public function handle(CharacterData $data): Character
    {
        $status = $this->requiresApproval() ? Pending::class : Active::class;

        ray($status);

        return Character::create(array_merge(
            $data->all(),
            ['status' => $status]
        ));
    }

    protected function requiresApproval(): bool
    {
        $user = auth()->user();

        if ($user->can('create', Character::class)) {
            return false;
        }

        if (settings('characters.allowCharacterCreation')) {
            if (! settings('characters.requireApprovalForCharacterCreation')) {
                return false;
            }

            ray(
                settings('characters.enforceCharacterLimits'),
                $user->activeCharacters()->count(),
                settings('characters.characterLimit'),
                $user->activeCharacters()->count() < settings('characters.characterLimit')
            );

            if (settings('characters.enforceCharacterLimits') && $user->activeCharacters()->count() < settings('characters.characterLimit')) {
                return false;
            }
        }

        return true;
    }
}
