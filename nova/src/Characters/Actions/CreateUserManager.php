<?php

namespace Nova\Users\Actions;

use Illuminate\Http\Request;
use Nova\Users\Models\User;
use Nova\Users\DataTransferObjects\UserData;

class CreateUserManager
{
    protected $createUser;

    protected $updateUserRoles;

    protected $uploadUserAvatar;

    public function __construct(
        CreateUser $createUser,
        UpdateUserRoles $updateUserRoles,
        UploadUserAvatar $uploadUserAvatar
    ) {
        $this->createUser = $createUser;
        $this->updateUserRoles = $updateUserRoles;
        $this->uploadUserAvatar = $uploadUserAvatar;
    }

    public function execute(Request $request): User
    {
        $user = $this->createUser->execute(
            $data = UserData::fromRequest($request)
        );

        $this->updateUserRoles->execute($user, $data->roles);

        $this->uploadUserAvatar->execute($user, $request->avatar_path);

        return $user->fresh();
    }
}
