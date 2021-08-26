<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Items;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\UpdateRankItem;
use Nova\Ranks\Concerns\FindRankImages;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Requests\UpdateRankItemRequest;
use Nova\Ranks\Responses\Items\UpdateRankItemResponse;

class UpdateRankItemController extends Controller
{
    use FindRankImages;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(RankItem $item)
    {
        $this->authorize('update', $item);

        return app(UpdateRankItemResponse::class)->with([
            'groups' => RankGroup::orderBySort()->get(),
            'item' => $item,
            'names' => RankName::orderBySort()->get(),
            'baseImages' => $this->getRankBaseImages(),
            'overlayImages' => $this->getRankOverlayImages(),
        ]);
    }

    public function update(
        UpdateRankItemRequest $request,
        UpdateRankItem $action,
        RankItem $item
    ) {
        $this->authorize('update', $item);

        $item = $action->execute($item, RankItemData::fromRequest($request));

        return back()->withToast('Rank item was updated');
    }
}
