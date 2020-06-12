<?php

namespace Nova\Foundation\Exceptions;

use Exception;

class IconNotFound extends Exception
{
    public static function missing(string $set, string $name)
    {
        return new static("Svg by name ${name} from set ${set} not found.");
    }
}
