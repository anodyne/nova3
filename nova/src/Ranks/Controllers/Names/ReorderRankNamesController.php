<?php

namespace Nova\Ranks\Controllers\Names;

use Illuminate\Http\Request;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Actions\ReorderRankNames;
use Nova\Foundation\Controllers\Controller;

class ReorderRankNamesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, ReorderRankNames $action)
    {
        $this->authorize('update', new RankName);

        $action->execute($request->sort);

        return redirect()
            ->route('ranks.names.index')
            ->withToast('Rank name sort order has been updated');
    }
}
