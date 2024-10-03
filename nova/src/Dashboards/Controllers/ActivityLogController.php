<?php

declare(strict_types=1);

namespace Nova\Dashboards\Controllers;

use Nova\Dashboards\Responses\ListActivityLogResponse;
use Nova\Dashboards\Responses\ShowActivityLogResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Activity::class);
    }

    public function index()
    {
        return ListActivityLogResponse::send();
    }

    public function show(Activity $activity): Responsable
    {
        return ShowActivityLogResponse::sendWith([
            'activity' => $activity,
        ]);
    }
}
