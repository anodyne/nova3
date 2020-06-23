<?php

namespace Nova\Ranks\Http\Controllers\Groups;

use Illuminate\Http\Request;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\ReorderRankGroups;
use Nova\Foundation\Http\Controllers\Controller;

class ReorderRankGroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, ReorderRankGroups $action)
    {
        $this->authorize('update', new RankGroup);

        $action->execute($request->sort);

        return redirect()
            ->route('ranks.groups.index')
            ->withToast('Rank group sort order has been updated');
    }
}
