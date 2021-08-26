<?php

declare(strict_types=1);

namespace Nova\Departments\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowAllPositionsResponse extends Responsable
{
    public $view = 'positions.index';
}
