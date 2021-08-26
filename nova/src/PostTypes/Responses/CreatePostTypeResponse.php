<?php

declare(strict_types=1);

namespace Nova\PostTypes\Responses;

use Nova\Foundation\Responses\Responsable;

class CreatePostTypeResponse extends Responsable
{
    public $view = 'post-types.create';
}
