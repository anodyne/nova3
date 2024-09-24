<?php

declare(strict_types=1);

namespace Nova\Discussions\Controllers;

use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Responses\ListDiscussionsResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class DiscussionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index(?Discussion $discussion = null): Responsable
    {
        return ListDiscussionsResponse::sendWith([
            'discussion' => $discussion,
        ]);
    }
}
