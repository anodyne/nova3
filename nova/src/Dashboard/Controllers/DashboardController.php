<?php

namespace Nova\Dashboard\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Dashboard\Responses\DashboardResponse;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        return app(DashboardResponse::class);
    }
}
