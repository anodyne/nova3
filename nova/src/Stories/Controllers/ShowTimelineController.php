<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Responses\ShowStoryTimelineResponse;

class ShowTimelineController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(string $type)
    {
        return ShowStoryTimelineResponse::sendWith([
            'type' => $type,
        ]);
    }
}
