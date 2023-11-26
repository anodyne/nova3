<?php

declare(strict_types=1);

namespace Nova\Stories\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewWritingDashboard extends SpotlightCommand
{
    protected string $name = 'View Writing Dashboard';

    protected string $description = 'View the writing dashboard';

    protected array $synonyms = [
        'saved posts', 'in progres posts', 'write',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('writing-overview');
    }
}
