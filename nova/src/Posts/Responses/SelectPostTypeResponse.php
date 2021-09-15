<?php

declare(strict_types=1);

namespace Nova\Posts\Responses;

use Nova\Foundation\Responses\Responsable;

class SelectPostTypeResponse extends Responsable
{
    public ?string $subnav = 'writing';

    public string $view = 'posts.create';
}
