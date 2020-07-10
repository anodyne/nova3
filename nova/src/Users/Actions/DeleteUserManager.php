<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;

class DeleteUserManager
{
    protected $deleteUser;

    protected $deleteUserCharacters;

    public function __construct(
        DeleteUser $deleteUser,
        DeleteUserCharacters $deleteUserCharacters
    ) {
        $this->deleteUser = $deleteUser;
        $this->deleteUserCharacters = $deleteUserCharacters;
    }

    public function execute(User $user): User
    {
        $this->deleteUserCharacters->execute($user);

        $this->deleteUser->execute($user);

        return $user;
    }
}
