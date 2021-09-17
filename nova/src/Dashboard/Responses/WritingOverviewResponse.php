<?php

declare(strict_types=1);

namespace Nova\Dashboard\Responses;

use Nova\Foundation\Responses\Responsable;

class WritingOverviewResponse extends Responsable
{
    public ?string $subnav = 'writing';

    public string $view = 'dashboards.writing-overview';
}
