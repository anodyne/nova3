<?php

namespace Nova\PostTypes\Controllers;

use Illuminate\Http\Request;
use Nova\PostTypes\Models\PostType;
use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Filters\PostTypeFilters;
use Nova\PostTypes\Responses\ShowPostTypeResponse;
use Nova\PostTypes\Responses\ShowAllPostTypesResponse;

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

        $postTypes = PostType::with('role')
            ->filter($filters)
            ->orderBySort();

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
        $this->authorize('view', $postType);

        return app(ShowPostTypeResponse::class)->with([
            'postType' => $postType,
        ]);
    }
}
