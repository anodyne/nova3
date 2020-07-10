<?php

namespace Nova\Users\Actions;

use Illuminate\Http\Request;
use Nova\Users\DataTransferObjects\AssignUserCharactersData;
use Nova\Users\Models\User;
use Nova\Users\DataTransferObjects\UserData;

class CreateUserManager
{
    protected $assignUserCharacters;

    protected $createUser;

    protected $updateUserRoles;

    protected $uploadUserAvatar;

    public function __construct(
        CreateUser $createUser,
        UpdateUserRoles $updateUserRoles,
        UploadUserAvatar $uploadUserAvatar,
        AssignUserCharacters $assignUserCharacters
    ) {
        $this->createUser = $createUser;
        $this->updateUserRoles = $updateUserRoles;
        $this->uploadUserAvatar = $uploadUserAvatar;
        $this->assignUserCharacters = $assignUserCharacters;
    }

    public function execute(Request $request): User
    {
        $user = $this->createUser->execute(
            $data = UserData::fromRequest($request)
        );

        $user = $this->assignUserCharacters->execute(
            $user,
            AssignUserCharactersData::fromRequest($request)
        );

        $this->updateUserRoles->execute($user, $data->roles);

        $this->uploadUserAvatar->execute($user, $request->avatar_path);

        return $user->fresh();
    }
}
