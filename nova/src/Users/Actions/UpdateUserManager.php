<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Nova\Users\DataTransferObjects\AssignUserCharactersData;
use Nova\Users\DataTransferObjects\UserData;

class UpdateUserManager
{
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

    public function execute(User $user, Request $request): User
    {
        $user = $this->updateUser->execute(
            $user,
            $data = UserData::fromRequest($request)
        );

        $user = $this->assignUserCharacters->execute(
            $user,
            AssignUserCharactersData::fromRequest($request)
        );

        $this->updateStatus->execute($user, $request->status);

        $this->updateRoles->execute($user, $data->roles);

        $this->uploadAvatar->execute($user, $request->avatar_path);

        // $this->removeAvatar->execute($user, $request->input('remove_avatar', false));

        return $user->refresh();
    }
}
