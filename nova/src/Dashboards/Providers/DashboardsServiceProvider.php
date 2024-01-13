<?php

declare(strict_types=1);

namespace Nova\Dashboards\Providers;

use Nova\Dashboards\Livewire\ActivityLogList;
use Nova\Dashboards\Livewire\CopyDiagnosticDataButton;
use Nova\Dashboards\Policies\ActivityPolicy;
use Nova\Dashboards\Spotlight\ViewSystemDashboard;
use Nova\Dashboards\Spotlight\ViewUserDashboard;
use Nova\DomainServiceProvider;
use Spatie\Activitylog\Models\Activity;

class DashboardsServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'dashboard:activity-log-list' => ActivityLogList::class,
            'copy-diagnostic-data-button' => CopyDiagnosticDataButton::class,
        ];
    }

    public function policies(): array
    {
        return [
            Activity::class => ActivityPolicy::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            ViewSystemDashboard::class,
            ViewUserDashboard::class,
        ];
    }
}
