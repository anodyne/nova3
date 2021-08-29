<?php

declare(strict_types=1);

namespace Nova\Departments\Responses;

use Nova\Foundation\Responses\Responsable;

class CreatePositionResponse extends Responsable
{
    public string $view = 'positions.create';
}
