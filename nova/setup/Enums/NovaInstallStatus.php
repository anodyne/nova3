<?php

declare(strict_types=1);

namespace Nova\Setup\Enums;

enum NovaInstallStatus: string
{
    case alreadyInstalled = 'already-installed';

    case failed = 'failed';

    case success = 'success';
}
