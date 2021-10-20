<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Posts\Filters\PostFilters;
use Nova\Posts\Models\Post;
use Nova\Stories\Filters\StoryFilters;
use Nova\Stories\Models\Story;
use Nova\Stories\Responses\ShowAllStoriesResponse;
use Nova\Stories\Responses\ShowStoryResponse;

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
            ->defaultOrder()
            ->filter($filters)
            ->get()
            ->toTree();

        return ShowAllStoriesResponse::sendWith([
            'stories' => $stories,
        ]);
    }

    public function show(Request $request, PostFilters $filters, Story $story)
    {
        $this->authorize('view', $story);

        $posts = Post::with('type')
            ->hasParent()
            ->whereStory($story->id)
            ->defaultOrder()
            ->filter($filters)
            ->paginate();

        return ShowStoryResponse::sendWith([
            'posts' => $posts,
            'search' => $request->search,
            'story' => $story->loadCount('posts'),
        ]);
    }
}
