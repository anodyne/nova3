<?php

declare(strict_types=1);

namespace Nova\Dashboards\Providers;

use Nova\Dashboards\Responses\DashboardResponse;
use Nova\Dashboards\Responses\SystemOverviewResponse;
use Nova\Dashboards\Responses\WritingOverviewResponse;
use Nova\DomainServiceProvider;

class DashboardsServiceProvider extends DomainServiceProvider
{
    public function responsables(): array
    {
        return [
            DashboardResponse::class,
            SystemOverviewResponse::class,
            WritingOverviewResponse::class,
        ];
    }
}
