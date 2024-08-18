<?php

declare(strict_types=1);

namespace Nova\Settings\Responses;

use Nova\Foundation\Responses\Responsable;

class ApplicationSettingsResponse extends Responsable
{
    public ?string $subnav = 'settings';

    public string $view = 'settings.applications';
}
