<?php

declare(strict_types=1);

namespace Nova\Users\Responses;

use Nova\Foundation\Responses\Responsable;

class NotificationPreferencesResponse extends Responsable
{
    public string $view = 'users.account.notifications';
}
