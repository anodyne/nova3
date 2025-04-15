<?php

declare(strict_types=1);

namespace Nova\Dashboards\Providers;

use Nova\Dashboards\Livewire\ActivityLogList;
use Nova\Dashboards\Livewire\ClearNovaCacheButton;
use Nova\Dashboards\Livewire\ClearVersionCheckCacheButton;
use Nova\Dashboards\Livewire\CopyDiagnosticDataButton;
use Nova\Dashboards\Livewire\CopyStacktraceButton;
use Nova\Dashboards\Livewire\ErrorLogViewer;
use Nova\Dashboards\Livewire\MaintenanceModeSwitch;
use Nova\Dashboards\Livewire\NovaUpdatePanel;
use Nova\Dashboards\Livewire\NovaUpdatePanelTrigger;
use Nova\Dashboards\Livewire\NovaVersionHistory;
use Nova\Dashboards\Livewire\PostingLeaderboard;
use Nova\Dashboards\Livewire\RebuildSearchIndexButton;
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
            'activity-log-list' => ActivityLogList::class,
            'clear-nova-cache-button' => ClearNovaCacheButton::class,
            'clear-version-check-cache-button' => ClearVersionCheckCacheButton::class,
            'copy-diagnostic-data-button' => CopyDiagnosticDataButton::class,
            'copy-stacktrace-button' => CopyStacktraceButton::class,
            'error-log-viewer' => ErrorLogViewer::class,
            'maintenance-mode-switch' => MaintenanceModeSwitch::class,
            'nova-update-panel' => NovaUpdatePanel::class,
            'nova-update-panel-trigger' => NovaUpdatePanelTrigger::class,
            'nova-version-history' => NovaVersionHistory::class,
            'posting-leaderboard' => PostingLeaderboard::class,
            'rebuild-search-index-button' => RebuildSearchIndexButton::class,
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
