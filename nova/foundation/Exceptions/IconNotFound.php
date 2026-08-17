<?php

declare(strict_types=1);

namespace Nova\Foundation\Exceptions;

use Exception;

class IconNotFound extends Exception
{
    public static function missing(string $set, string $name): self
    {
        return new self("Svg by name {$name} from set {$set} not found.");
    }
}
