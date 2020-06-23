<?php

namespace Nova\Ranks\Http\Controllers\Items;

use Illuminate\Http\Request;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Actions\ReorderRankItems;
use Nova\Foundation\Http\Controllers\Controller;

class ReorderRankItemsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, ReorderRankItems $action)
    {
        $this->authorize('update', new RankItem);

        $action->execute($request->sort);

        return redirect()
            ->route('ranks.items.index')
            ->withToast('Rank item sort order has been updated');
    }
}
