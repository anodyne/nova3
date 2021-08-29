<?php

declare(strict_types=1);

namespace Nova\Themes\Exceptions;

use Exception;

class ThemeException extends Exception
{
    public static function missingQuickInstallFile()
    {
        return new self("A Quick Install file could not be found.");
    }

    public static function themeAlreadyExists($location)
    {
        return new self("Theme scaffold could not be created because the theme [{$location}] already exists.");
    }
}
