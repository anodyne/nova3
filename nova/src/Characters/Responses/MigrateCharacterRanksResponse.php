<?php

declare(strict_types=1);

namespace Nova\Characters\Responses;

use Nova\Foundation\Responses\Responsable;

class MigrateCharacterRanksResponse extends Responsable
{
    public ?string $subnav = 'characters';

    public string $view = 'characters.migrate-ranks';
}
