<?php

namespace Nova\Ranks\Controllers\Groups;

use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\UpdateRankGroup;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Requests\UpdateRankGroupRequest;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Responses\Groups\UpdateRankGroupResponse;

class UpdateRankGroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(RankGroup $group)
    {
        $this->authorize('update', $group);

        return app(UpdateRankGroupResponse::class)->with([
            'group' => $group->load('ranks.name'),
        ]);
    }

    public function update(
        UpdateRankGroupRequest $request,
        UpdateRankGroup $action,
        RankGroup $group
    ) {
        $this->authorize('update', $group);

        $group = $action->execute($group, RankGroupData::fromRequest($request));

        return back()->withToast("{$group->name} was updated");
    }
}
