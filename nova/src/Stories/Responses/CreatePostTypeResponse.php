<?php

declare(strict_types=1);

namespace Nova\Stories\Responses;

use Nova\Foundation\Responses\Responsable;

class CreatePostTypeResponse extends Responsable
{
    public ?string $subnav = 'storytelling';

    public string $view = 'post-types.create';
}
