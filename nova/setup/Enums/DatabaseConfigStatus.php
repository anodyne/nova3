<?php

declare(strict_types=1);

namespace Nova\Setup\Enums;

enum DatabaseConfigStatus: string
{
    case alreadyConfigured = 'already-configured';

    case failedToVerify = 'failed-to-verify';

    case failedToWriteEnv = 'failed-to-write-env';

    case failure = 'failure';

    case incompatibleDriver = 'incompatible-driver';

    case incompatibleVersion = 'incompatible-version';

    case notConfigured = 'not-configured';

    case success = 'success';
}
