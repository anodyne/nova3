<?php

declare(strict_types=1);

namespace Nova\Reporting\Livewire;

use Livewire\Component;
use Nova\Reporting\Data\ParticipationReport;

class PlayerParticipationWidget extends Component
{
    public ParticipationReport $stats;

    public string $changeBadge;

    public bool $showLink = false;

    public function render()
    {
        return view('pages.reporting.livewire.player-participation-widget');
    }
}
