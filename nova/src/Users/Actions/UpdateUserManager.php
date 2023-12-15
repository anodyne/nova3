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

        if (filled($request->assigned_characters)) {
            $user = SyncUserCharacters::run($user, $request->getUserCharactersData());
        }

        if (filled($request->assigned_roles)) {
            $user = SyncUserRoles::run($user, $request->getUserRolesData());
        }

        UploadUserAvatar::run($user, $request->image_path);

        RemoveUserAvatar::run($user, $request->boolean('remove_existing_image', false));

        return $user->refresh();
    }
}
