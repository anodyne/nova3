<?php

declare(strict_types=1);

namespace Nova\Users\Exceptions;

use Exception;

class CannotDeleteOwnAccountException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            message: 'You cannot delete your own account.'
        );
    }
}
