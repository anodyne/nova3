<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Items;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\CreateRankItem;
use Nova\Ranks\Concerns\FindRankImages;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Requests\CreateRankItemRequest;
use Nova\Ranks\Responses\Items\CreateRankItemResponse;

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

        $rank = $action->execute(RankItemData::fromRequest($request));

        $group = strtolower($rank->group->name);

        return redirect()
            ->route('ranks.items.index', "group={$group}")
            ->withToast('Rank item was created');
    }
}
