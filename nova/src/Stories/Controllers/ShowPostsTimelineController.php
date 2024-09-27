<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Responses\ShowPostsTimelineResponse;

class ShowPostsTimelineController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        return ShowPostsTimelineResponse::send();
    }
}
