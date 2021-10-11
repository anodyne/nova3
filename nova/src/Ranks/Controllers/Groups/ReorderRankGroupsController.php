<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Groups;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\ReorderRankGroups;
use Nova\Ranks\Models\RankGroup;

class ReorderRankGroupsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        $this->authorize('update', new RankGroup());

        ReorderRankGroups::run($request->sort);

        return redirect()
            ->route('ranks.groups.index')
            ->withToast('Rank group sort order has been updated');
    }
}
