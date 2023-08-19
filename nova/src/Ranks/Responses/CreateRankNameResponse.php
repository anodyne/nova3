<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses;

use Nova\Foundation\Responses\Responsable;

class CreateRankNameResponse extends Responsable
{
    public ?string $subnav = 'characters';

    public string $view = 'ranks.names.create';
}
