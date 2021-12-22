<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Data\UserData;
use Nova\Users\Models\User;

class UpdateUserManager
{
    use AsAction;

    public function handle(User $user, Request $request): User
    {
        $user = UpdateUser::run($user, UserData::from($request));

        UploadUserAvatar::run($user, $request->avatar_path);

        // RemoveUserAvatar::run($user, $request->input('remove_avatar', false));

        return $user->refresh();
    }
}
