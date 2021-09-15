<?php

declare(strict_types=1);

namespace Nova\Dashboard\Responses;

use Nova\Foundation\Responses\Responsable;

class SystemOverviewResponse extends Responsable
{
    public ?string $subnav = 'system';

    public string $view = 'system-overview';
}
