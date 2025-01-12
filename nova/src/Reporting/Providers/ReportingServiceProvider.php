<?php

declare(strict_types=1);

namespace Nova\Reporting\Providers;

use Nova\DomainServiceProvider;
use Nova\Reporting\Livewire\PlayerActivityWidget;
use Nova\Reporting\Livewire\PlayerParticipationWidget;

class ReportingServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'widget-player-activity' => PlayerActivityWidget::class,
            'widget-player-participation' => PlayerParticipationWidget::class,
        ];
    }
}
