<?php

namespace Nova\Stories\Controllers\PostTypes;

use Illuminate\Http\Request;
use Nova\Stories\Models\PostType;
use Nova\Stories\Filters\PostTypeFilters;
use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Responses\PostTypes\ShowPostTypeResponse;
use Nova\Stories\Responses\PostTypes\ShowAllPostTypesResponse;

class ShowPostTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request, PostTypeFilters $filters)
    {
        $this->authorize('viewAny', PostType::class);

        $postTypes = PostType::filter($filters)->orderBySort();

        $postTypes = ($isReordering = $request->has('reorder'))
            ? $postTypes->get()
            : $postTypes->paginate();

        return app(ShowAllPostTypesResponse::class)->with([
            'isReordering' => $isReordering,
            'postTypes' => $postTypes,
            'search' => $request->search,
        ]);
    }

    public function show(PostType $postType)
    {
        return app(ShowPostTypeResponse::class)->with([
            'postType' => $postType,
        ]);
    }
}
