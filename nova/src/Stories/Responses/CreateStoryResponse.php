<?php

declare(strict_types=1);

namespace Nova\Stories\Responses;

use Nova\Foundation\Responses\Responsable;

class CreateStoryResponse extends Responsable
{
    public $view = 'stories.create';
}
