<?php

declare(strict_types=1);

namespace Nova\Stories\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowStoryResponse extends Responsable
{
    public $view = 'stories.show';
}
