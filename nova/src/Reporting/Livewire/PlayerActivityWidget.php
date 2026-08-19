<?php

declare(strict_types=1);

namespace Nova\Reporting\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Nova\Reporting\Data\ActivityReport;

class PlayerActivityWidget extends Component
{
    public ActivityReport $stats;

    public string $changeBadge;

    public bool $showLink = false;

    public function render(): Factory|View
    {
        return view('pages.reporting.livewire.player-activity-widget');
    }
}
