<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses\Items;

use Nova\Foundation\Responses\Responsable;

class CreateRankItemResponse extends Responsable
{
    public string $view = 'ranks.items.create';
}
