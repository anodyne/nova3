<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Names;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Filters\RankNameFilters;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Responses\Names\ShowAllRankNamesResponse;
use Nova\Ranks\Responses\Names\ShowRankNameResponse;

class ShowRankNameController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request, RankNameFilters $filters)
    {
        $this->authorize('viewAny', RankName::class);

        $names = RankName::withCount('ranks')
            ->filter($filters)
            ->orderBySort();

        $names = ($request->has('reorder'))
            ? $names->get()
            : $names->paginate();

        return ShowAllRankNamesResponse::sendWith([
            'isReordering' => $request->has('reorder'),
            'nameCount' => RankName::count(),
            'names' => $names,
            'search' => $request->search,
        ]);
    }

    public function show(RankName $name)
    {
        $this->authorize('view', $name);

        return ShowRankNameResponse::sendWith([
            'name' => $name->load('ranks.group'),
        ]);
    }
}
