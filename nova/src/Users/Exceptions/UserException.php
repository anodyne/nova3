<?php

declare(strict_types=1);

namespace Nova\Users\Exceptions;

use Exception;
use Illuminate\Support\Facades\Auth;

class UserException extends Exception
{
    public static function adminForcedPasswordReset()
    {
        Auth::logout();

        throw new AdminForcedPasswordResetException();
    }

    public static function cannotDeleteOwnAccount()
    {
        return new self('You cannot delete your own account.');
    }
}
