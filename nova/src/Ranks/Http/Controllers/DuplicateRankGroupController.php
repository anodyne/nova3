<?php

namespace Nova\Ranks\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\DuplicateRankGroup;
use Nova\Ranks\Events\RankGroupDuplicated;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Ranks\Actions\DuplicateRankGroupManager;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Http\Responses\DuplicateRankGroupResponse;
use Symfony\Component\Finder\Finder;

class DuplicateRankGroupController extends Controller
{
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

        event(new RankGroupDuplicated($group, $originalGroup));

        return redirect()
            ->route('ranks.groups.edit', $group)
            ->withToast("{$originalGroup->name} has been duplicated");
    }

    protected function getRankBaseImages(): array
    {
        $finder = new Finder;
        $finder->in(base_path('ranks/base'))->files();

        $baseImages = [];

        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $baseImages[] = $file->getRelativePathname();
            }
        }

        sort($baseImages);

        return $baseImages;
    }
}
