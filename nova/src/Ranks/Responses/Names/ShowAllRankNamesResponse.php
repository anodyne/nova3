<?php

declare(strict_types=1);

namespace Nova\Ranks\Responses\Names;

use Nova\Foundation\Responses\Responsable;

class ShowAllRankNamesResponse extends Responsable
{
    public ?string $subnav = 'characters';

    public string $view = 'ranks.names.index';
}
