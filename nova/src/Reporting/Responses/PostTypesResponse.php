<?php

declare(strict_types=1);

namespace Nova\Reporting\Responses;

use Nova\Foundation\Responses\Responsable;

class PostTypesResponse extends Responsable
{
    public ?string $subnav = 'reporting';

    public string $view = 'reporting.post-types';
}
