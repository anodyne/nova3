<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Actions\ReorderStories;
use Nova\Stories\Models\Story;
use Nova\Stories\Responses\ReorderStoriesResponse;

class ReorderStoriesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function showReorder(Request $request)
    {
        $this->authorize('update', new Story());

        $stories = Story::query()
            ->ordered()
            ->get()
            ->toTree();

        return ReorderStoriesResponse::sendWith([
            'stories' => $stories,
        ]);
    }

    public function reorder(Request $request)
    {
        $this->authorize('update', new Story());

        ReorderStories::run($request->sort);

        return redirect()
            ->route('stories.index')
            ->withToast('Stories have been re-ordered');
    }
}
