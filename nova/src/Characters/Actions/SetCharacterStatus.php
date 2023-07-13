<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Pending;

class SetCharacterStatus
{
    use AsAction;

    public function handle(Character $character): Character
    {
        if (
            $character->type === CharacterType::primary && settings('characters.requirePrimaryApproval') ||
            $character->type === CharacterType::secondary && settings('characters.requireSecondaryApproval') ||
            $character->type === CharacterType::support && settings('characters.requireSupportApproval')
        ) {
            if ($character->status->canTransitionTo(Pending::class)) {
                $character->status->transitionTo(Pending::class);
            }
        }

        return $character->refresh();
    }
}
