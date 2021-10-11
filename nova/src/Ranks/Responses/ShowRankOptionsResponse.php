<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowRankOptionsResponse extends Responsable
{
    public string $view = 'ranks.index';
}
