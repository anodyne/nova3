<?php

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Nova\Stories\Filters\StoryFilters;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Responses\ShowStoryResponse;
use Nova\Stories\Responses\ShowAllStoriesResponse;

class ShowStoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request, StoryFilters $filters)
    {
        $this->authorize('viewAny', Story::class);

        $stories = Story::hasParent()
            ->filter($filters)
            ->get()
            ->toTree();

        return app(ShowAllStoriesResponse::class)->with([
            'stories' => $stories,
        ]);
    }

    public function show(Story $story)
    {
        $this->authorize('view', $story);

        return app(ShowStoryResponse::class)->with([
            'story' => $story,
        ]);
    }
}
