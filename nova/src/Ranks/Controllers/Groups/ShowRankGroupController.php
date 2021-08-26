<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Groups;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Filters\RankGroupFilters;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Responses\Groups\ShowAllRankGroupsResponse;
use Nova\Ranks\Responses\Groups\ShowRankGroupResponse;

class ShowRankGroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request, RankGroupFilters $filters)
    {
        $this->authorize('viewAny', RankGroup::class);

        $groups = RankGroup::withCount('ranks')
            ->filter($filters)
            ->orderBySort();

        $groups = ($request->has('reorder'))
            ? $groups->get()
            : $groups->paginate();

        return app(ShowAllRankGroupsResponse::class)->with([
            'groupCount' => RankGroup::count(),
            'groups' => $groups,
            'isReordering' => $request->has('reorder'),
            'search' => $request->search,
        ]);
    }

    public function show(RankGroup $group)
    {
        $this->authorize('view', $group);

        return app(ShowRankGroupResponse::class)->with([
            'group' => $group->load('ranks.name'),
        ]);
    }
}
