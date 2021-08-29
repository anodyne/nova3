<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Items;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\ReorderRankItems;
use Nova\Ranks\Models\RankItem;

class ReorderRankItemsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        $this->authorize('update', new RankItem());

        ReorderRankItems::run($request->sort);

        return redirect()
            ->route('ranks.items.index')
            ->withToast('Rank item sort order has been updated');
    }
}
