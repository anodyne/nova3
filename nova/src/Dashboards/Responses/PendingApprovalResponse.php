<?php

declare(strict_types=1);

namespace Nova\Dashboards\Responses;

use Nova\Foundation\Responses\Responsable;

class PendingApprovalResponse extends Responsable
{
    public string $view = 'dashboards.pending-approval';
}
