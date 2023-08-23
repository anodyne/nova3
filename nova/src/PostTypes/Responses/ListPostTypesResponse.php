<?php

declare(strict_types=1);

namespace Nova\PostTypes\Responses;

use Nova\Foundation\Responses\Responsable;

class ListPostTypesResponse extends Responsable
{
    public ?string $subnav = 'writing';

    public string $view = 'post-types.index';
}
