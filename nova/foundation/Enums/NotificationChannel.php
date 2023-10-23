<?php

declare(strict_types=1);

namespace Nova\Foundation\Enums;

enum NotificationChannel: string
{
    case database = 'database';

    case discord = 'discord';

    case mail = 'mail';
}
