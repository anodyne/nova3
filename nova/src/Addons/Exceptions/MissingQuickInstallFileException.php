<?php

declare(strict_types=1);

namespace Nova\Addons\Exceptions;

use Exception;

class MissingQuickInstallFileException extends Exception
{
    public function __construct(string $location)
    {
        parent::__construct(
            message: "A Quick Install file could not be found for the add-on [{$location}]."
        );
    }
}
