<?php

declare(strict_types=1);

namespace Nova\Dashboard\Responses;

use Nova\Foundation\Responses\Responsable;

class DashboardResponse extends Responsable
{
    public string $view = 'dashboard';
}
