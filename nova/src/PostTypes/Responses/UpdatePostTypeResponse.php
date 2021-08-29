<?php

declare(strict_types=1);

namespace Nova\PostTypes\Responses;

use Nova\Foundation\Responses\Responsable;

class UpdatePostTypeResponse extends Responsable
{
    public string $view = 'post-types.edit';
}
