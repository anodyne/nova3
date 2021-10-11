<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Items;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Filters\RankItemFilters;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Responses\Items\ShowAllRankItemsResponse;
use Nova\Ranks\Responses\Items\ShowRankItemResponse;

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
            ->orderBySort();

        $items = ($request->has('reorder'))
            ? $items->get()
            : $items->paginate();

        return app(ShowAllRankItemsResponse::class)->with([
            'groups' => RankGroup::orderBySort()->get(),
            'isReordering' => $request->has('reorder'),
            'itemCount' => RankItem::count(),
            'items' => $items,
            'search' => $request->search,
        ]);
    }

    public function show(RankItem $item)
    {
        $this->authorize('view', $item);

        return app(ShowRankItemResponse::class)->with([
            'item' => $item->load('group', 'name', 'characters'),
        ]);
    }
}
