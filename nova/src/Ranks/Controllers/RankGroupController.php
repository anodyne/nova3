<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\Actions\UpdateRankGroup;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Requests\StoreRankGroupRequest;
use Nova\Ranks\Requests\UpdateRankGroupRequest;
use Nova\Ranks\Responses\CreateRankGroupResponse;
use Nova\Ranks\Responses\EditRankGroupResponse;
use Nova\Ranks\Responses\ListRankGroupsResponse;
use Nova\Ranks\Responses\ShowRankGroupResponse;

class RankGroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(RankGroup::class, 'group');
    }

    public function index()
    {
        return ListRankGroupsResponse::send();
    }

    public function show(RankGroup $group)
    {
        return ShowRankGroupResponse::sendWith([
            'group' => $group->load('ranks.name'),
        ]);
    }

    public function create()
    {
        return CreateRankGroupResponse::send();
    }

    public function store(StoreRankGroupRequest $request)
    {
        $group = CreateRankGroup::run($request->getRankGroupData());

        return redirect()
            ->route('ranks.groups.index')
            ->notify("{$group->name} rank group was created");
    }

    public function edit(RankGroup $group)
    {
        return EditRankGroupResponse::sendWith([
            'group' => $group,
        ]);
    }

    public function update(UpdateRankGroupRequest $request, RankGroup $group)
    {
        $group = UpdateRankGroup::run($group, $request->getRankGroupData());

        return back()->notify("{$group->name} was updated");
    }
}
