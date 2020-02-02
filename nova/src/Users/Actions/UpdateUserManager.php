<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Nova\Users\DataTransferObjects\UserData;

class UpdateUserManager
{
    protected $updateUser;

    protected $uploadAvatar;

    public function __construct(
        UpdateUser $updateUser,
        UploadUserAvatar $uploadAvatar
    ) {
        $this->updateUser = $updateUser;
        $this->uploadAvatar = $uploadAvatar;
    }

    public function execute(User $user, Request $request): User
    {
        $this->updateUser->execute($user, UserData::fromRequest($request));

        $this->uploadAvatar->execute($user, $request->file('image'));

        return $user->refresh();
    }
}
