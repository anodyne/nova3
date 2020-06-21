<?php

namespace Nova\Ranks\Http\Controllers\Items;

use Illuminate\Http\Request;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Filters\RankItemFilters;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Ranks\Http\Responses\Items\ShowRankItemResponse;
use Nova\Ranks\Http\Responses\Items\ShowAllRankItemsResponse;

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

        $items = RankItem::withRankName()
            ->filter($filters)
            ->paginate();

        return app(ShowAllRankItemsResponse::class)->with([
            'groups' => RankGroup::get(),
            'items' => $items,
            'search' => $request->search,
        ]);
    }

    public function show(RankItem $item)
    {
        $this->authorize('view', $item);

        return app(ShowRankItemResponse::class)->with([
            'item' => $item->load('group', 'name'),
        ]);
    }
}
