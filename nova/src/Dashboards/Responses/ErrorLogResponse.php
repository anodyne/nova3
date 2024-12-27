<?php

declare(strict_types=1);

namespace Nova\Dashboards\Responses;

use Nova\Foundation\Responses\Responsable;

class ErrorLogResponse extends Responsable
{
    public ?string $subnav = 'system';

    public string $view = 'dashboards.error-logs';
}
