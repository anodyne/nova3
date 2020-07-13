<?php

namespace Nova\Dashboard\Providers;

use Nova\DomainServiceProvider;
use Nova\Dashboard\Responses\DashboardResponse;

class DashboardServiceProvider extends DomainServiceProvider
{
    protected $responsables = [
        DashboardResponse::class,
    ];
}
