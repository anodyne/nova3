<?php

declare(strict_types=1);

namespace Nova\Dashboard\Providers;

use Nova\Dashboard\Responses\DashboardResponse;
use Nova\Dashboard\Responses\SystemOverviewResponse;
use Nova\Dashboard\Responses\WritingOverviewResponse;
use Nova\DomainServiceProvider;

class DashboardServiceProvider extends DomainServiceProvider
{
    protected array $responsables = [
        DashboardResponse::class,
        SystemOverviewResponse::class,
        WritingOverviewResponse::class,
    ];
}
