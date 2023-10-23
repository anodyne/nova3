<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;
use Nova\Users\Requests\UpdateUserRequest;

class UpdateUserManager
{
    use AsAction;

    public function handle(User $user, UpdateUserRequest $request): User
    {
        $user = UpdateUser::run($user, $request->getUserData());

        $user = SyncUserCharacters::run($user, $request->getUserCharactersData());

        $user = SyncUserRoles::run($user, $request->getUserRolesData());

        UploadUserAvatar::run($user, $request->avatar_path);

        // RemoveUserAvatar::run($user, $request->input('remove_avatar', false));

        return $user->refresh();
    }
}
