<?php

namespace Nova\Ranks\Http\Controllers\Groups;

use Illuminate\Http\Request;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Filters\RankGroupFilters;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Ranks\Http\Responses\Groups\ShowRankGroupResponse;
use Nova\Ranks\Http\Responses\Groups\ShowAllRankGroupsResponse;

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
            ->paginate();

        return app(ShowAllRankGroupsResponse::class)->with([
            'groups' => $groups,
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
