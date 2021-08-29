<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\DataTransferObjects\AssignUserCharactersData;
use Nova\Users\DataTransferObjects\UserData;
use Nova\Users\Models\User;

class UpdateUserManager
{
    use AsAction;

    protected $assignUserCharacters;

    protected $updateUser;

    protected $updateRoles;

    protected $updateStatus;

    protected $uploadAvatar;

    protected $removeAvatar;

    public function __construct(
        UpdateUser $updateUser,
        UpdateUserStatus $updateStatus,
        UpdateUserRoles $updateRoles,
        UploadUserAvatar $uploadAvatar,
        RemoveUserAvatar $removeAvatar,
        AssignUserCharacters $assignUserCharacters
    ) {
        $this->updateUser = $updateUser;
        $this->updateStatus = $updateStatus;
        $this->updateRoles = $updateRoles;
        $this->uploadAvatar = $uploadAvatar;
        $this->removeAvatar = $removeAvatar;
        $this->assignUserCharacters = $assignUserCharacters;
    }

    public function handle(User $user, Request $request): User
    {
        $user = UpdateUser::run(
            $user,
            $data = UserData::fromRequest($request)
        );

        $user = AssignUserCharacters::run(
            $user,
            AssignUserCharactersData::fromRequest($request)
        );

        UpdateUserStatus::run($user, $request->status);

        UpdateUserRoles::run($user, $data->roles);

        UploadUserAvatar::run($user, $request->avatar_path);

        // RemoveUserAvatar::run($user, $request->input('remove_avatar', false));

        return $user->refresh();
    }
}
