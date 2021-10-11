<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class UploadUserAvatar
{
    use AsAction;

    public function handle(User $user, $imagePath): User
    {
        if ($imagePath !== null) {
            $user->addMedia($imagePath)->toMediaCollection('avatar');
        }

        return $user->refresh();
    }
}
