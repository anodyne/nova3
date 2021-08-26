<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses\Groups;

use Nova\Foundation\Responses\Responsable;

class ShowAllRankGroupsResponse extends Responsable
{
    public $view = 'ranks.groups.index';
}
