<?php

declare(strict_types=1);

namespace Nova\Dashboard\Controllers;

use Nova\Dashboard\Responses\WritingOverviewResponse;
use Nova\Foundation\Controllers\Controller;

class WritingOverviewController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        return app(WritingOverviewResponse::class);
    }
}
