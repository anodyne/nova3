<?php

namespace Nova\Dashboard\Http\Controllers;

use Nova\Foundation\Http\Controllers\Controller;
use Nova\Dashboard\Http\Responses\DashboardResponse;

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
