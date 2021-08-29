<?php

declare(strict_types=1);

namespace Nova\Settings\Responses;

use Nova\Foundation\Responses\Responsable;

class SettingsResponse extends Responsable
{
    public string $view = 'settings.index';
}
