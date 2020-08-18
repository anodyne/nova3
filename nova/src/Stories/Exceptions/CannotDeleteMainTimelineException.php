<?php

namespace Nova\Stories\Exceptions;

use Exception;

class StoryException extends Exception
{
    public function __construct()
    {
        parent::__construct('You cannot delete the main timeline');
    }
}
