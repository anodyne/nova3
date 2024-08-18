<?php

declare(strict_types=1);

namespace Nova\Applications\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowApplicationResponse extends Responsable
{
    // public ?string $subnav = 'characters';

    public string $view = 'applications.show';
}
