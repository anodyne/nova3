<?php

declare(strict_types=1);

namespace Nova\Foundation\Exceptions;

use Exception;

class ActionException extends Exception
{
    public function render($request)
    {
        return back()->withErrorToast($this->message);
    }
}
