<?php

namespace Nova\Ranks\Http\Controllers\Items;

use Illuminate\Http\Request;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Actions\DeleteRankItem;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Ranks\Http\Responses\Items\DeleteRankItemResponse;

class DeleteRankItemController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $item = RankItem::findOrFail($request->id);

        return app(DeleteRankItemResponse::class)->with([
            'item' => $item,
        ]);
    }

    public function destroy(DeleteRankItem $action, RankItem $item)
    {
        $this->authorize('delete', $item);

        $action->execute($item);

        return redirect()
            ->route('ranks.items.index')
            ->withToast("Rank item was deleted", 'Any character with this rank will need a new rank assigned to them.');
    }
}
