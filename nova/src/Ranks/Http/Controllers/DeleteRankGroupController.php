<?php

namespace Nova\Ranks\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\DeleteRankGroup;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Ranks\Http\Responses\DeleteRankGroupResponse;

class DeleteRankGroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $group = RankGroup::findOrFail($request->id);

        return app(DeleteRankGroupResponse::class)->with([
            'group' => $group,
        ]);
    }

    public function destroy(DeleteRankGroup $action, RankGroup $group)
    {
        $this->authorize('delete', $group);

        $action->execute($group);

        return redirect()
            ->route('ranks.groups.index')
            ->withToast("{$group->name} was deleted", 'All ranks assigned to this group have also been deleted.');
    }
}
