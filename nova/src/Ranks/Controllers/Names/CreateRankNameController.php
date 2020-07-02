<?php

namespace Nova\Ranks\Controllers\Names;

use Nova\Ranks\Models\RankName;
use Nova\Ranks\Actions\CreateRankName;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Requests\CreateRankNameRequest;
use Nova\Ranks\DataTransferObjects\RankNameData;
use Nova\Ranks\Responses\Names\CreateRankNameResponse;

class CreateRankNameController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', RankName::class);

        return app(CreateRankNameResponse::class);
    }

    public function store(CreateRankNameRequest $request, CreateRankName $action)
    {
        $this->authorize('create', RankName::class);

        $name = $action->execute(RankNameData::fromRequest($request));

        return redirect()
            ->route('ranks.names.index')
            ->withToast("{$name->name} rank name was created");
    }
}
