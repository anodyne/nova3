<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Items;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\DeleteRankItem;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Responses\Items\DeleteRankItemResponse;

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

        return DeleteRankItemResponse::sendWith([
            'item' => $item->load('group', 'name'),
        ]);
    }

    public function destroy(RankItem $item)
    {
        $this->authorize('delete', $item);

        DeleteRankItem::run($item);

        return redirect()
            ->route('ranks.items.index')
            ->withToast("{$item->name->name} rank item was deleted from the {$item->group->name} rank group", 'Any character who had this rank will need a new rank assigned to them.');
    }
}
