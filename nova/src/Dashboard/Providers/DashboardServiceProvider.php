<?php

declare(strict_types=1);

namespace Nova\Dashboard\Providers;

use Nova\Dashboard\Responses\DashboardResponse;
use Nova\DomainServiceProvider;

class DashboardServiceProvider extends DomainServiceProvider
{
    protected $responsables = [
        DashboardResponse::class,
    ];
}
