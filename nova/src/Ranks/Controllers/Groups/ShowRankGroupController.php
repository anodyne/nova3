<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Groups;

use Nova\Foundation\Controllers\Controller;
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

    public function all()
    {
        $this->authorize('viewAny', RankGroup::class);

        return ShowAllRankGroupsResponse::send();
    }

    public function show(RankGroup $group)
    {
        $this->authorize('view', $group);

        return ShowRankGroupResponse::sendWith([
            'group' => $group->load('ranks.name'),
        ]);
    }
}
