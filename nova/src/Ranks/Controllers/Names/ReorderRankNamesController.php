<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Names;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\ReorderRankNames;
use Nova\Ranks\Models\RankName;

class ReorderRankNamesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, ReorderRankNames $action)
    {
        $this->authorize('update', new RankName());

        $action->execute($request->sort);

        return redirect()
            ->route('ranks.names.index')
            ->withToast('Rank name sort order has been updated');
    }
}
