<?php

declare(strict_types=1);

namespace Nova\Users\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminForcedPasswordResetException extends Exception
{
    public function __construct()
    {
        parent::__construct('An admin has required that you to reset your password before you can continue.');
    }

    public function render(Request $request): RedirectResponse
    {
        return redirect()
            ->route('password.request')
            ->with('message', $this->getMessage());
    }

    public function report(): bool
    {
        return false;
    }
}
