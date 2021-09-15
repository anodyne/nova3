<?php

declare(strict_types=1);

namespace Nova\Dashboard\Controllers;

use Nova\Dashboard\Responses\SystemOverviewResponse;
use Nova\Foundation\Controllers\Controller;

class SystemOverviewController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        return app(SystemOverviewResponse::class);
    }
}
