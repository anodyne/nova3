<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Actions\CreateStoryManager;
use Nova\Stories\Actions\DeleteStoriesManager;
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
    }

    public function index()
    {
        $this->authorize('viewAny', Story::class);

        return ListStoriesResponse::send();
    }

    public function show(Story $story)
    {
        $this->authorize('view', $story);

        return ShowStoryResponse::sendWith([
            'story' => $story
                ->loadCount('posts', 'recursivePosts')
                ->loadSum(['recursivePosts', 'posts'], 'word_count'),
            'ancestors' => $story->ancestors->splice(1),
        ]);
    }

    public function create()
    {
        $this->authorize('create', Story::class);

        return CreateStoryResponse::send();
    }

    public function store(StoreStoryRequest $request)
    {
        $this->authorize('create', Story::class);

        $story = CreateStoryManager::run($request);

        return redirect()
            ->route('admin.stories.index')
            ->notify("{$story->title} story was created");
    }

    public function edit(Story $story)
    {
        $this->authorize('update', $story);

        return EditStoryResponse::sendWith([
            'story' => $story,
        ]);
    }

    public function update(UpdateStoryRequest $request, Story $story)
    {
        $this->authorize('update', $story);

        $story = UpdateStoryManager::run($story, $request);

        return redirect()
            ->route('admin.stories.edit', $story)
            ->notify("{$story->title} was updated");
    }

    public function delete($id)
    {
        $this->authorize('delete', new Story);

        $stories = Story::with('parent')
            ->ordered()
            ->find($id)
            ->descendantsAndSelf;

        return DeleteStoryResponse::sendWith([
            'storiesToDelete' => $stories,
        ]);
    }

    public function destroy(Request $request)
    {
        $this->authorize('delete', new Story);

        $deletedStories = DeleteStoriesManager::run($request);

        return redirect()
            ->route('admin.stories.index')
            ->notify($deletedStories.' '.trans_choice('story was|stories were', $deletedStories).' deleted');
    }
}
