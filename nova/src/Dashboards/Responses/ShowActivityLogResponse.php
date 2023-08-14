<?php

declare(strict_types=1);

namespace Nova\Dashboards\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowActivityLogResponse extends Responsable
{
    public ?string $subnav = 'system';

    public string $view = 'dashboards.activity-log.show';
}
