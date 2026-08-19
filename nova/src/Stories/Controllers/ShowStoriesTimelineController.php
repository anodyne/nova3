<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Stories\Responses\ShowStoriesTimelineResponse;

class ShowStoriesTimelineController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(): Responsable
    {
        return ShowStoriesTimelineResponse::send();
    }
}
