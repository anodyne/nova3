<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses\Items;

use Nova\Foundation\Responses\Responsable;

class ShowRankItemResponse extends Responsable
{
    public string $view = 'ranks.items.show';
}
