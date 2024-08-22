<?php

declare(strict_types=1);

namespace Nova\Dashboards\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewUserDashboard extends SpotlightCommand
{
    protected string $name = 'View User Dashboard';

    protected string $description = 'View the main dashboard';

    protected array $synonyms = [
        'admin control panel',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.dashboard');
    }
}
