<?php

declare(strict_types=1);

namespace Nova\Dashboards\Controllers;

use Nova\Dashboards\Responses\DashboardResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(): Responsable
    {
        return DashboardResponse::send();
    }
}
