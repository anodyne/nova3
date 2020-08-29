<?php

namespace Nova\Stories\Controllers;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Nova\Stories\Filters\StoryFilters;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Responses\ShowStoryResponse;
use Nova\Stories\Responses\ShowAllStoriesResponse;

class ShowStoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request, StoryFilters $filters)
    {
        $stories = Story::defaultOrder()->get()->toTree();

        $storiesArr = [];

        $traverse = function ($nodes) use (&$traverse, &$storiesArr) {
            $data = [];

            foreach ($nodes as $node) {
                $nodeData = [
                    'id' => $node->id,
                    'title' => $node->title,
                ];

                if ($node->getDescendantCount() > 0) {
                    $nodeData['children'][] = $traverse($node->children);
                }

                $data[] = $nodeData;
            }

            return $data;
        };

        $storiesArr = $traverse($stories);

        dd($storiesArr);

        $stories = $stories->map(fn ($story) => ['id' => $story->id, 'parent_id' => $story->parent_id]);

        dd($stories->toArray());

        $this->authorize('viewAny', Story::class);

        $stories = Story::hasParent()
            ->filter($filters)
            ->get()
            ->toTree();

        return app(ShowAllStoriesResponse::class)->with([
            'stories' => $stories,
        ]);
    }

    public function show(Story $story)
    {
        $this->authorize('view', $story);

        return app(ShowStoryResponse::class)->with([
            'story' => $story,
        ]);
    }
}
