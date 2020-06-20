<?php

namespace Nova\Ranks\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Filters\RankItemFilters;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Ranks\Http\Responses\ShowRankItemResponse;
use Nova\Ranks\Http\Responses\ShowAllRankItemsResponse;
use Nova\Ranks\Models\RankGroup;

class ShowRankItemController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request, RankItemFilters $filters)
    {
        $this->authorize('viewAny', RankItem::class);

        $items = RankItem::with('name')
            ->filter($filters)
            ->paginate();

        return app(ShowAllRankItemsResponse::class)->with([
            'groups' => RankGroup::get(),
            'items' => $items,
            'search' => $request->search,
        ]);
    }

    public function show(RankItem $name)
    {
        $this->authorize('view', $name);

        return app(ShowRankItemResponse::class)->with([
            'name' => $name,
        ]);
    }
}
