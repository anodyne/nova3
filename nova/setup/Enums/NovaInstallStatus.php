<?php

declare(strict_types=1);

namespace Nova\Setup\Enums;

enum NovaInstallStatus: string
{
    case AlreadyInstalled = 'already-installed';

    case Failed = 'failed';

    case Success = 'success';
}
