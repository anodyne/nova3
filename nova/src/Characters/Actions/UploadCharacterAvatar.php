<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;

class UploadCharacterAvatar
{
    use AsAction;

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
