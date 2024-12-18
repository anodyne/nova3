<?php

declare(strict_types=1);

namespace Nova\Reporting\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Reporting\Responses\GameOverviewResponse;

class GameOverviewController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        // Participation - get a list of users who are part of a post in the
        // published or draft state in the last X number of days who have a
        // sum total of post words on those posts of greater than 0

        return GameOverviewResponse::send();
    }
}
