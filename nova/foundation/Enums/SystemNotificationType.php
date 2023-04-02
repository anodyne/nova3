<?php

declare(strict_types=1);

namespace Nova\Foundation\Enums;

enum SystemNotificationType: string
{
    case admin = 'admin';

    case collective = 'collective';

    case personal = 'personal';
}
