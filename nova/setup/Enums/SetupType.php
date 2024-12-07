<?php

declare(strict_types=1);

namespace Nova\Setup\Enums;

use Nova\Setup\Steps\Install;
use Nova\Setup\Steps\Update;

enum SetupType: string
{
    case Install = 'install';

    case Update = 'update';

    public function getSteps()
    {
        return match ($this) {
            self::Install => new Install,
            self::Update => new Update,
            default => null,
        };
    }
}
