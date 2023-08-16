<?php

declare(strict_types=1);

namespace Nova\Departments\Responses;

use Nova\Foundation\Responses\Responsable;

class EditPositionResponse extends Responsable
{
    public ?string $subnav = 'characters';

    public string $view = 'positions.edit';
}
