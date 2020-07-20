<?php

namespace Nova\Stories\Controllers;

use Nova\Stories\Models\Story;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Responses\ShowAllStoriesResponse;

class ShowStoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all()
    {
        $this->authorize('viewAny', Story::class);

        return app(ShowAllStoriesResponse::class)->with([
            'stories' => Story::orderBySortDesc()->get(),
        ]);
    }
}
