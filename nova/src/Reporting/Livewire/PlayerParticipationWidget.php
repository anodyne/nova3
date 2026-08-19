<?php

declare(strict_types=1);

namespace Nova\Reporting\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Nova\Reporting\Data\ParticipationReport;

class PlayerParticipationWidget extends Component
{
    public ParticipationReport $stats;

    public string $changeBadge;

    public bool $showLink = false;

    public function render(): Factory|View
    {
        return view('pages.reporting.livewire.player-participation-widget');
    }
}
