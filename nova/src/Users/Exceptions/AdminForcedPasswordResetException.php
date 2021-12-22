<?php

declare(strict_types=1);

namespace Nova\Users\Exceptions;

use Exception;

class AdminForcedPasswordResetException extends Exception
{
    public function __construct()
    {
        parent::__construct('An admin has required that you to reset your password before you can continue.');
    }

    public function render($request)
    {
        return redirect()
            ->route('password.request')
            ->with('message', $this->getMessage());
    }

    public function report()
    {
        return false;
    }
}
