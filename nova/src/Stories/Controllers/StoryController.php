<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Actions\CreateStoryManager;
use Nova\Stories\Actions\DeleteStoryManager;
use Nova\Stories\Actions\UpdateStoryManager;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\StoreStoryRequest;
use Nova\Stories\Requests\UpdateStoryRequest;
use Nova\Stories\Responses\CreateStoryResponse;
use Nova\Stories\Responses\DeleteStoryResponse;
use Nova\Stories\Responses\EditStoryResponse;
use Nova\Stories\Responses\ListStoriesResponse;
use Nova\Stories\Responses\ShowStoryResponse;

class StoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Story::class);
    }

    public function index()
    {
        return ListStoriesResponse::send();
    }

    public function show(Story $story)
    {
        return ShowStoryResponse::sendWith([
            'story' => $story->loadCount('posts', 'recursivePosts')->loadSum('recursivePosts', 'word_count'),
            'ancestors' => $story->ancestors->splice(1),
        ]);
    }

    public function create()
    {
        return CreateStoryResponse::send();
    }

    public function store(StoreStoryRequest $request)
    {
        $story = CreateStoryManager::run($request);

        return redirect()
            ->route('stories.index')
            ->withToast("{$story->title} story was created");
    }

    public function edit(Story $story)
    {
        return EditStoryResponse::sendWith([
            'story' => $story,
        ]);
    }

    public function update(UpdateStoryRequest $request, Story $story)
    {
        $story = UpdateStoryManager::run($story, $request);

        return redirect()
            ->route('stories.edit', $story)
            ->withToast("{$story->title} was updated");
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
        DeleteStoryManager::run($request);

        return redirect()
            ->route('stories.index')
            ->withToast('Story was deleted', 'All posts in this story have been deleted as well.');
    }
}
