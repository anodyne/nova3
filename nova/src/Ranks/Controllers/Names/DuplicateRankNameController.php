<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Names;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\DuplicateRankName;
use Nova\Ranks\Events\RankNameDuplicated;
use Nova\Ranks\Models\RankName;

class DuplicateRankNameController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(RankName $original)
    {
        $this->authorize('duplicate', $original);

        $name = DuplicateRankName::run($original);

        RankNameDuplicated::dispatch($name, $original);

        return redirect()
            ->route('ranks.names.edit', $name)
            ->withToast("{$original->name} has been duplicated");
    }
}
