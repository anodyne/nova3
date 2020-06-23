<?php

namespace Nova\Ranks\Http\Controllers\Groups;

use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Http\Requests\CreateRankGroupRequest;
use Nova\Ranks\Http\Responses\Groups\CreateRankGroupResponse;

class CreateRankGroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', RankGroup::class);

        return app(CreateRankGroupResponse::class);
    }

    public function store(CreateRankGroupRequest $request, CreateRankGroup $action)
    {
        $this->authorize('create', RankGroup::class);

        $group = $action->execute(RankGroupData::fromRequest($request));

        return redirect()
            ->route('ranks.groups.index')
            ->withToast("{$group->name} rank group was created");
    }
}
