<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Nova\Users\DataTransferObjects\UserData;

class UpdateUserManager
{
    /**
     * @var  UpdateUser
     */
    protected $updateUser;

    /**
     * @var  UpdateUserStatus
     */
    protected $updateUserStatus;

    /**
     * @var  UploadUserAvatar
     */
    protected $uploadAvatar;

    /**
     * @var  RemoveUserAvatar
     */
    protected $removeAvatar;

    public function __construct(
        UpdateUser $updateUser,
        UpdateUserStatus $updateUserStatus,
        UploadUserAvatar $uploadAvatar,
        RemoveUserAvatar $removeAvatar
    ) {
        $this->updateUser = $updateUser;
        $this->updateUserStatus = $updateUserStatus;
        $this->uploadAvatar = $uploadAvatar;
        $this->removeAvatar = $removeAvatar;
    }

    public function execute(User $user, Request $request): User
    {
        $this->updateUser->execute($user, UserData::fromRequest($request));

        $this->updateUserStatus->execute($user, $request->status);

        // $this->uploadAvatar->execute($user, $request->file('avatar'));
        $this->uploadAvatar->execute($user, $request->avatar_path);

        // $this->removeAvatar->execute($user, $request->input('remove_avatar', false));

        return $user->refresh();
    }
}
