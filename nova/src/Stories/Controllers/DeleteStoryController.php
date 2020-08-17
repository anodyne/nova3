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

    public function delete($storyId)
    {
        $storiesToDelete = Story::descendantsAndSelf($storyId);

        // $stories = Story::whereNotIn('id', $storiesToDelete->map(fn ($s) => $s->id)->toArray())->get();

        // $storiesToDelete->each(fn ($s) => dump($s->title));
        // $story->descendants->dd();
        // dd('Done');

        return app(DeleteStoryResponse::class)->with([
            'storiesToDelete' => $storiesToDelete,
        ]);
    }

    public function confirm(Request $request)
    {
        $story = Story::findOrFail($request->id);

        $storiesToDelete = Story::whereDescendantAndSelf($request->id)->get();
        dd($storiesToDelete);

        $stories = Story::whereNotIn('id', [$story->id])
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
