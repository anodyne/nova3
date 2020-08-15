<?php

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Actions\DeleteStoryManager;
use Nova\Stories\Responses\DeleteStoryResponse;

class DeleteStoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $story = Story::findOrFail($request->id);

        $stories = Story::whereNotIn('id', [1, $story->id])
            ->orderBy('_lft')
            ->get();

        return app(DeleteStoryResponse::class)->with([
            'story' => $story,
            'stories' => $stories,
        ]);
    }

    public function destroy(Request $request, DeleteStoryManager $action, Story $story)
    {
        $this->authorize('delete', $story);

        $action->execute($request, $story);

        return redirect()
            ->route('stories.index')
            ->withToast("{$story->title} was deleted", 'All posts in this story have been deleted as well.');
    }
}
