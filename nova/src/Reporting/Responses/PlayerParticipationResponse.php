<?php

declare(strict_types=1);

namespace Nova\Reporting\Responses;

use Nova\Foundation\Responses\Responsable;

class PlayerParticipationResponse extends Responsable
{
    public ?string $subnav = 'reporting';

    public string $view = 'reporting.player-participation';
}
