<?php

declare(strict_types=1);

namespace Nova\Dashboards\Responses;

use Nova\Foundation\Responses\Responsable;

class WhatsNewResponse extends Responsable
{
    public ?string $subnav = 'whats-new';

    public string $view = 'dashboards.whats-new.index';
}
