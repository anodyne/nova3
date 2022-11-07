<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Items;

use Nova\Foundation\Controllers\Controller;
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

    public function all()
    {
        $this->authorize('viewAny', RankItem::class);

        return ShowAllRankItemsResponse::send();
    }

    public function show(RankItem $item)
    {
        $this->authorize('view', $item);

        return ShowRankItemResponse::sendWith([
            'item' => $item->load('group', 'name', 'characters'),
        ]);
    }
}
