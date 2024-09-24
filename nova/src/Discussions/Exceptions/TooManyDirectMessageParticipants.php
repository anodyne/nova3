<?php

declare(strict_types=1);

namespace Nova\Discussions\Exceptions;

use Exception;

class TooManyDirectMessageParticipants extends Exception
{
    protected $message = 'Direct messages can only have 2 participants';
}
