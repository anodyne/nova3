<?php

declare(strict_types=1);

namespace Nova\Applications\Responses;

use Nova\Foundation\Responses\Responsable;

class ListApplicationsResponse extends Responsable
{
    // public ?string $subnav = 'applications';

    public string $view = 'applications.index';
}
