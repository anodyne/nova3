<?php

declare(strict_types=1);

namespace Nova\Discussions\Responses;

use Nova\Foundation\Responses\Responsable;

class ListDiscussionsResponse extends Responsable
{
    public string $view = 'discussions.index';
}
