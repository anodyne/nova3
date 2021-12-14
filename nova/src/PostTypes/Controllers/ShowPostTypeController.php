<?php

declare(strict_types=1);

namespace Nova\PostTypes\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Filters\PostTypeFilters;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Responses\ShowAllPostTypesResponse;
use Nova\PostTypes\Responses\ShowPostTypeResponse;

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

        return ShowAllPostTypesResponse::sendWith([
            'isReordering' => $isReordering,
            'postTypes' => $postTypes,
            'search' => $request->search,
        ]);
    }

    public function show(PostType $postType)
    {
        $this->authorize('view', $postType);

        return ShowPostTypeResponse::sendWith([
            'postType' => $postType,
        ]);
    }
}
