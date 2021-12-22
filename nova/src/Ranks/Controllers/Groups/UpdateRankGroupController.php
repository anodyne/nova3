<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Groups;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\UpdateRankGroup;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Requests\UpdateRankGroupRequest;
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

        return UpdateRankGroupResponse::sendWith([
            'group' => $group->load('ranks.name'),
        ]);
    }

    public function update(UpdateRankGroupRequest $request, RankGroup $group)
    {
        $this->authorize('update', $group);

        $group = UpdateRankGroup::run($group, RankGroupData::from($request));

        return back()->withToast("{$group->name} was updated");
    }
}
