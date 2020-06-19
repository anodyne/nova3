<?php

namespace Nova\Ranks\Http\Controllers;

use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\DuplicateRankGroup;
use Nova\Ranks\Events\RankGroupDuplicated;
use Nova\Foundation\Http\Controllers\Controller;

class DuplicateRankGroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(
        DuplicateRankGroup $action,
        RankGroup $originalGroup
    ) {
        $this->authorize('duplicate', $originalGroup);

        $group = $action->execute($originalGroup);

        event(new RankGroupDuplicated($group, $originalGroup));

        return redirect()
            ->route('ranks.groups.edit', $group)
            ->withToast("{$originalGroup->name} has been duplicated");
    }
}
