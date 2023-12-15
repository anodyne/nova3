<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class UploadUserAvatar
{
    use AsAction;

    public function handle(User $user, ?string $path = null): User
    {
        if (filled($path)) {
            $user->addMedia($path)->toMediaCollection('avatar');
        }

        return $user->refresh();
    }
}
