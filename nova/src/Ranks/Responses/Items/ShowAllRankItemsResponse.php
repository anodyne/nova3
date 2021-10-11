<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses\Items;

use Nova\Foundation\Responses\Responsable;

class ShowAllRankItemsResponse extends Responsable
{
    public ?string $subnav = 'characters';

    public string $view = 'ranks.items.index';
}
