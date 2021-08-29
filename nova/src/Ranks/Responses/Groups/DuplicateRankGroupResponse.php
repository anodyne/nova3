<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses\Groups;

use Nova\Foundation\Responses\Responsable;

class DuplicateRankGroupResponse extends Responsable
{
    public string $view = 'ranks.groups.duplicate';
}
