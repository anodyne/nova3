<?php

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
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

    public function all(Request $request)
    {
        $this->authorize('viewAny', Story::class);

        $stories = Story::hasParent();

        $stories = ($request->has('reversed'))
            ? $stories->defaultOrder()
            : $stories->reversed();

        return app(ShowAllStoriesResponse::class)->with([
            'stories' => $stories->get()->toTree(),
        ]);
    }
}
