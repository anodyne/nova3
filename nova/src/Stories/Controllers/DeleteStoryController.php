<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Actions\DeleteStoryManager;
use Nova\Stories\Exceptions\StoryException;
use Nova\Stories\Models\Story;
use Nova\Stories\Responses\DeleteStoryResponse;

class DeleteStoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function delete($id)
    {
        $this->authorize('delete', new Story());

        $stories = Story::defaultOrder()->descendantsAndSelf($id);

        throw_if(
            $stories->where('id', 1)->count() > 0,
            StoryException::cannotDeleteMainTimeline()
        );

        return app(DeleteStoryResponse::class)->with([
            'storiesToDelete' => $stories,
        ]);
    }

    public function destroy(Request $request, DeleteStoryManager $action)
    {
        $this->authorize('delete', new Story());

        $action->execute($request);

        return redirect()
            ->route('stories.index')
            ->withToast('Story was deleted', 'All posts in this story have been deleted as well.');
    }
}
