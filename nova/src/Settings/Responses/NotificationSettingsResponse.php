<?php

declare(strict_types=1);

namespace Nova\Settings\Responses;

use Nova\Foundation\Responses\Responsable;

class NotificationSettingsResponse extends Responsable
{
    public ?string $subnav = 'settings';

    public string $view = 'settings.notifications';
}
