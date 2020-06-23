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
            'item' => $item->load('group', 'name'),
        ]);
    }

    public function destroy(DeleteRankItem $action, RankItem $item)
    {
        $this->authorize('delete', $item);

        $action->execute($item);

        return redirect()
            ->route('ranks.items.index')
            ->withToast("{$item->name->name} rank item was deleted from the {$item->group->name} rank group", 'Any character who had this rank will need a new rank assigned to them.');
    }
}
