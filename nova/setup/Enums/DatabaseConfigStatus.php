<?php

declare(strict_types=1);

namespace Nova\Setup\Enums;

enum DatabaseConfigStatus: string
{
    case AlreadyConfigured = 'already-configured';

    case FailedToVerify = 'failed-to-verify';

    case FailedToWriteEnv = 'failed-to-write-env';

    case Failure = 'failure';

    case IncompatibleDriver = 'incompatible-driver';

    case IncompatibleVersion = 'incompatible-version';

    case NotConfigured = 'not-configured';

    case Success = 'success';
}
