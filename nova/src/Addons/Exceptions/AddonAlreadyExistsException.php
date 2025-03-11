<?php

declare(strict_types=1);

namespace Nova\Addons\Exceptions;

use Exception;

class AddonAlreadyExistsException extends Exception
{
    public function __construct(string $location)
    {
        parent::__construct(
            message: "Add-on scaffold could not be created because the add-on [{$location}] already exists."
        );
    }
}
