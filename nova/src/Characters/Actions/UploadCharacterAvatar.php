<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;

class UploadCharacterAvatar
{
    use AsAction;

    public function handle(Character $character, $imagePath): Character
    {
        if ($imagePath !== null) {
            $character->addMedia($imagePath)->toMediaCollection('avatar');

            activity()
                ->performedOn($character)
                ->event('uploaded-avatar')
                ->log('uploaded-avatar');
        }

        return $character->refresh();
    }
}
