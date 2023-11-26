<?php

declare(strict_types=1);

namespace Nova\Stories\Responses;

use Nova\Foundation\Responses\Responsable;

class WritingOverviewResponse extends Responsable
{
    public ?string $subnav = 'writing';

    public string $view = 'dashboards.writing-overview';
}
