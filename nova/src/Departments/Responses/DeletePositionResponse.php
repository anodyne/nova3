<?php

declare(strict_types=1);

namespace Nova\Departments\Responses;

use Nova\Foundation\Responses\Responsable;

class DeletePositionResponse extends Responsable
{
    public $view = 'positions.delete';
}
