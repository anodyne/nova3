<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses\Groups;

use Nova\Foundation\Responses\Responsable;

class DeleteRankGroupResponse extends Responsable
{
    public string $view = 'ranks.groups.delete';
}
