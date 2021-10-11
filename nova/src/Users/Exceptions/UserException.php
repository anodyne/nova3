<?php

declare(strict_types=1);

namespace Nova\Users\Exceptions;

use Exception;

class UserException extends Exception
{
    public static function adminForcedPasswordReset()
    {
        return new self('An admin is requiring that you reset your password.');
    }

    public static function cannotDeleteOwnAccount()
    {
        return new self('You cannot delete your own account.');
    }
}
