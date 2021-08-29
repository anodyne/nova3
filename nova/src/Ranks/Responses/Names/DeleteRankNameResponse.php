<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses\Names;

use Nova\Foundation\Responses\Responsable;

class DeleteRankNameResponse extends Responsable
{
    public string $view = 'ranks.names.delete';
}
