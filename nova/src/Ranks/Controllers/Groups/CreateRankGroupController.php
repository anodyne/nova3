<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Groups;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Requests\CreateRankGroupRequest;
use Nova\Ranks\Responses\Groups\CreateRankGroupResponse;

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

        return CreateRankGroupResponse::send();
    }

    public function store(CreateRankGroupRequest $request)
    {
        $this->authorize('create', RankGroup::class);

        $group = CreateRankGroup::run(RankGroupData::fromRequest($request));

        return redirect()
            ->route('ranks.groups.index')
            ->withToast("{$group->name} rank group was created");
    }
}
