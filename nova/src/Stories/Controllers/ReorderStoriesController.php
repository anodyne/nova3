<?php

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Nova\Stories\Actions\ReorderStories;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Responses\ReorderStoriesResponse;

class ShowStoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function showReorder(Request $request)
    {
        $this->authorize('update', new Story);

        $stories = Story::hasParent()
            ->defaultOrder()
            ->get()
            ->toTree();

        return app(ReorderStoriesResponse::class)->with([
            'stories' => $stories,
        ]);
    }

    public function reorder(Request $request, ReorderStories $action)
    {
        $this->authorize('update', new Story);

        $action->execute($request->sort);

        return redirect()
            ->route('stories.index')
            ->withToast('Stories have been re-ordered');
    }
}
