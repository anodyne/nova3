<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Support\Facades\Gate;
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

        return Character::create(array_merge(
            $data->toArray(),
            ['status' => $status]
        ));
    }

    protected function requiresApproval(): bool
    {
        if (Gate::allows('create', Character::class)) {
            return false;
        }

        $settings = settings();

        if ($settings->characters->allowCharacterCreation) {
            if (! $settings->characters->requireApprovalForCharacterCreation) {
                return false;
            }
        }

        return true;
    }
}
