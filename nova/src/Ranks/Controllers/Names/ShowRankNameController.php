<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Names;

use Nova\Foundation\Controllers\Controller;
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

    public function all()
    {
        $this->authorize('viewAny', RankName::class);

        return ShowAllRankNamesResponse::sendWith([
            'nameCount' => RankName::count(),
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
