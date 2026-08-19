<?php

declare(strict_types=1);

namespace Nova\Reporting\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Reporting\Reports\PostTypeReporter;
use Nova\Reporting\Responses\PostTypesResponse;

class PostTypesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(): Responsable
    {
        $postTypeReporter = PostTypeReporter::make();

        return PostTypesResponse::sendWith([
            'report' => $postTypeReporter->currentActivityTimeframe(),
            'settings' => settings('posting_activity'),
        ]);
    }
}
