<?php

declare(strict_types=1);

namespace Nova\Reporting\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Reporting\Reports\ActivityReporter;
use Nova\Reporting\Responses\PlayerActivityResponse;

class PlayerActivityController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(): Responsable
    {
        $activityReporter = ActivityReporter::make();

        return PlayerActivityResponse::sendWith([
            'activity' => $activityReporter,
            'settings' => settings('posting_activity'),
        ]);
    }
}
