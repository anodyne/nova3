<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Groups;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\DuplicateRankGroupManager;
use Nova\Ranks\Concerns\FindRankImages;
use Nova\Ranks\Events\RankGroupDuplicated;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Responses\Groups\DuplicateRankGroupResponse;

class DuplicateRankGroupController extends Controller
{
    use FindRankImages;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $group = RankGroup::findOrFail($request->id);

        return app(DuplicateRankGroupResponse::class)->with([
            'group' => $group,
            'baseImages' => $this->getRankBaseImages(),
        ]);
    }

    public function duplicate(
        Request $request,
        DuplicateRankGroupManager $action,
        RankGroup $originalGroup
    ) {
        $this->authorize('duplicate', $originalGroup);

        $group = $action->execute($originalGroup, $request);

        RankGroupDuplicated::dispatch($group, $originalGroup);

        return redirect()
            ->route('ranks.groups.edit', $group)
            ->withToast("{$group->name} has been created", "The rank items from {$originalGroup->name} have been duplicated with the new base image for your new rank group.");
    }
}
