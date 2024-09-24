<?php

declare(strict_types=1);

namespace Nova\Discussions\Exceptions;

use Exception;

class CannotLeaveDirectMessage extends Exception
{
    protected $message = 'You cannot leave a direct message';
}
