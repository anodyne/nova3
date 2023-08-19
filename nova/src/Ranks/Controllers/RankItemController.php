<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\CreateRankItem;
use Nova\Ranks\Actions\UpdateRankItem;
use Nova\Ranks\Concerns\FindRankImages;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Requests\StoreRankItemRequest;
use Nova\Ranks\Requests\UpdateRankItemRequest;
use Nova\Ranks\Responses\CreateRankItemResponse;
use Nova\Ranks\Responses\EditRankItemResponse;
use Nova\Ranks\Responses\ListRankItemsResponse;
use Nova\Ranks\Responses\ShowRankItemResponse;

class RankItemController extends Controller
{
    use FindRankImages;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(RankItem::class, 'item');
    }

    public function index()
    {
        return ListRankItemsResponse::send();
    }

    public function show(RankItem $item)
    {
        return ShowRankItemResponse::sendWith([
            'item' => $item->load('group', 'name', 'characters'),
        ]);
    }

    public function create()
    {
        return CreateRankItemResponse::sendWith([
            'groups' => RankGroup::ordered()->get(),
            'names' => RankName::ordered()->get(),
            'baseImages' => $this->getRankBaseImages(),
            'overlayImages' => $this->getRankOverlayImages(),
        ]);
    }

    public function store(StoreRankItemRequest $request)
    {
        CreateRankItem::run($request->getRankItemData());

        return redirect()
            ->route('ranks.items.index')
            ->withToast('Rank item was created');
    }

    public function edit(RankItem $item)
    {
        return EditRankItemResponse::sendWith([
            'groups' => RankGroup::ordered()->get(),
            'item' => $item,
            'names' => RankName::ordered()->get(),
            'baseImages' => $this->getRankBaseImages(),
            'overlayImages' => $this->getRankOverlayImages(),
        ]);
    }

    public function update(UpdateRankItemRequest $request, RankItem $item)
    {
        $item = UpdateRankItem::run($item, $request->getRankItemData());

        return back()->withToast('Rank item was updated');
    }
}
