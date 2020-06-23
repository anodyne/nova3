<?php

namespace Nova\Ranks\Http\Controllers\Items;

use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\CreateRankItem;
use Nova\Ranks\Concerns\FindRankImages;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Http\Requests\CreateRankItemRequest;
use Nova\Ranks\Http\Responses\Items\CreateRankItemResponse;

class CreateRankItemController extends Controller
{
    use FindRankImages;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', RankGroup::class);

        return app(CreateRankItemResponse::class)->with([
            'groups' => RankGroup::orderBySort()->get(),
            'names' => RankName::orderBySort()->get(),
            'baseImages' => $this->getRankBaseImages(),
            'overlayImages' => $this->getRankOverlayImages(),
        ]);
    }

    public function store(CreateRankItemRequest $request, CreateRankItem $action)
    {
        $this->authorize('create', RankItem::class);

        $action->execute(RankItemData::fromRequest($request));

        return redirect()
            ->route('ranks.items.index')
            ->withToast('Rank item was created');
    }
}
