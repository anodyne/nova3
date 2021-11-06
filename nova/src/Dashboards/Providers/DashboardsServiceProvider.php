<?php

declare(strict_types=1);

namespace Nova\Dashboards\Providers;

use Nova\Dashboards\Spotlight\ViewSystemDashboard;
use Nova\Dashboards\Spotlight\ViewUserDashboard;
use Nova\Dashboards\Spotlight\ViewWritingDashboard;
use Nova\DomainServiceProvider;

class DashboardsServiceProvider extends DomainServiceProvider
{
    public function spotlightCommands(): array
    {
        return [
            ViewSystemDashboard::class,
            ViewUserDashboard::class,
            ViewWritingDashboard::class,
        ];
    }
}
