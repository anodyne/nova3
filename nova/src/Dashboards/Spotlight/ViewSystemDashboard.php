<?php

declare(strict_types=1);

namespace Nova\Dashboards\Spotlight;

use Illuminate\Http\Request;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewSystemDashboard extends SpotlightCommand
{
    protected string $name = 'View System Dashboard';

    protected string $description = 'View the system dashboard';

    protected array $synonyms = [
        'nova version', 'database version', 'php version', 'laravel version',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.system-overview');
    }

    public function shouldBeShown(Request $request): bool
    {
        return $request->user()?->canManageSystem ?? false;
    }
}
