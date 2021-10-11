<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses\Groups;

use Nova\Foundation\Responses\Responsable;

class CreateRankGroupResponse extends Responsable
{
    public ?string $subnav = 'characters';

    public string $view = 'ranks.groups.create';
}
