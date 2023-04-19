<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Actions\DeleteStoryManager;
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

        $stories = Story::ordered()->find($id)->descendantsAndSelf;

        return DeleteStoryResponse::sendWith([
            'storiesToDelete' => $stories,
        ]);
    }

    public function destroy(Request $request)
    {
        $this->authorize('delete', new Story());

        DeleteStoryManager::run($request);

        return redirect()
            ->route('stories.index')
            ->withToast('Story was deleted', 'All posts in this story have been deleted as well.');
    }
}
