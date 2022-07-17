<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Posts\Filters\PostFilters;
use Nova\Posts\Models\Post;
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

    public function all()
    {
        $this->authorize('viewAny', Story::class);

        return ShowAllStoriesResponse::sendWith([
            'story' => new Story(),
            'storyCount' => Story::withDepth()->having('depth', '=', 1)->count(),
        ]);
    }

    public function show(Request $request, PostFilters $filters, Story $story)
    {
        $this->authorize('view', $story);

        $posts = Post::with('postType')
            ->hasParent()
            ->whereStory($story->id)
            ->wherePublished()
            ->defaultOrder()
            ->filter($filters)
            ->paginate();

        return ShowStoryResponse::sendWith([
            'posts' => $posts,
            'search' => $request->search,
            'story' => $story->loadCount('posts'),
            'ancestors' => $story->ancestors->splice(1),
        ]);
    }
}
