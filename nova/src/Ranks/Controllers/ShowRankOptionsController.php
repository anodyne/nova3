<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Responses\ShowRankOptionsResponse;

class ShowRankOptionsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        $this->authorize('viewAny', RankGroup::class);

        return app(ShowRankOptionsResponse::class);
    }
}
