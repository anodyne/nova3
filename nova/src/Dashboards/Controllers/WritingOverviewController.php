<?php

declare(strict_types=1);

namespace Nova\Dashboards\Controllers;

use Nova\Dashboards\Responses\WritingOverviewResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class WritingOverviewController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(): Responsable
    {
        return app(WritingOverviewResponse::class);
    }
}