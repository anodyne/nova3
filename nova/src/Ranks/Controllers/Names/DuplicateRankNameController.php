<?php

namespace Nova\Ranks\Controllers\Names;

use Nova\Ranks\Models\RankName;
use Nova\Ranks\Actions\DuplicateRankName;
use Nova\Ranks\Events\RankNameDuplicated;
use Nova\Foundation\Controllers\Controller;

class DuplicateRankNameController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(
        DuplicateRankName $action,
        RankName $originalName
    ) {
        $this->authorize('duplicate', $originalName);

        $name = $action->execute($originalName);

        RankNameDuplicated::dispatch($name, $originalName);

        return redirect()
            ->route('ranks.names.edit', $name)
            ->withToast("{$originalName->name} has been duplicated");
    }
}
