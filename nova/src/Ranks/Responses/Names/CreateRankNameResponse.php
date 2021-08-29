<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses\Names;

use Nova\Foundation\Responses\Responsable;

class CreateRankNameResponse extends Responsable
{
    public string $view = 'ranks.names.create';
}
