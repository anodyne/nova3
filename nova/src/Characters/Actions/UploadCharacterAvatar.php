<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;

class UploadCharacterAvatar extends Action
{
    public function handle(Character $character, ?string $path = null): Character
    {
        if (is_null($path)) {
            $character->clearMediaCollection('avatar');

            activity()
                ->performedOn($character)
                ->event('removed avatar')
                ->log('removed avatar');
        } else {
            $character->addMedia($path)->toMediaCollection('avatar');

            activity()
                ->performedOn($character)
                ->event('uploaded avatar')
                ->log('uploaded avatar');
        }

        return $character->refresh();
    }
}
