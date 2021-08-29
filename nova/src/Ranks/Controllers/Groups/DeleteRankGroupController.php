<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Groups;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\DeleteRankGroup;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Responses\Groups\DeleteRankGroupResponse;

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

    public function destroy(RankGroup $group)
    {
        $this->authorize('delete', $group);

        DeleteRankGroup::run($group);

        return redirect()
            ->route('ranks.groups.index')
            ->withToast("{$group->name} was deleted", 'All ranks assigned to this group have also been deleted.');
    }
}
