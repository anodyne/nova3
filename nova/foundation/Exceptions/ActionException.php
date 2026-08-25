<?php

declare(strict_types=1);

namespace Nova\Foundation\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ActionException extends Exception
{
    public function render(Request $request): RedirectResponse
    {
        return back()->notifyOfError($this->message);
    }
}
