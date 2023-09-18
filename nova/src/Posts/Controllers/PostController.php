<?php

declare(strict_types=1);

namespace Nova\Posts\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Posts\Models\Post;
use Nova\Posts\Responses\ShowPostResponse;
use Nova\Posts\Responses\WritePostResponse;
use Nova\Stories\Actions\CreateStoryManager;
use Nova\Stories\Actions\DeleteStoryManager;
use Nova\Stories\Actions\UpdateStoryManager;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\StoreStoryRequest;
use Nova\Stories\Requests\UpdateStoryRequest;
use Nova\Stories\Responses\DeleteStoryResponse;
use Nova\Stories\Responses\EditStoryResponse;
use Nova\Stories\Responses\ListStoriesResponse;

class PostController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Post::class);
    }

    public function index()
    {
        return ListStoriesResponse::send();
    }

    public function show(Post $post)
    {
        return ShowPostResponse::sendWith([
            'post' => $post->load('type', 'characterAuthors', 'userAuthors', 'story'),
            'story' => $post->story,
            'previousPost' => $post->prevSiblings()->published()->first(),
            'nextPost' => $post->nextSiblings()->published()->first(),
        ]);
    }

    public function create(Post $post)
    {
        return WritePostResponse::sendWith([
            'post' => $post,
        ]);
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
