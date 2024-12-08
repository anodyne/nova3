<?php

declare(strict_types=1);

namespace Nova\Addons\Exceptions;

use Exception;

class AddonException extends Exception
{
    public static function missingQuickInstallFile()
    {
        return new self('A Quick Install file could not be found.');
    }

    public static function addonAlreadyExists($location)
    {
        return new self("Add-on scaffold could not be created because the add-on [{$location}] already exists.");
    }

    public static function addonRanksAlreadyExists($location)
    {
        return new self("Add-on scaffold could not be created because the add-on ranks [{$location}] already exists.");
    }
}
