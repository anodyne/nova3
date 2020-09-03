<?php

namespace Nova\Stories\Exceptions;

use Exception;

class StoryException extends Exception
{
    public static function cannotDeleteMainTimeline()
    {
        return new self('You cannot delete the main timeline.');
    }
}
