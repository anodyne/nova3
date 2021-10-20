<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Names;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\CreateRankName;
use Nova\Ranks\DataTransferObjects\RankNameData;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Requests\CreateRankNameRequest;
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

        return CreateRankNameResponse::send();
    }

    public function store(CreateRankNameRequest $request)
    {
        $this->authorize('create', RankName::class);

        $name = CreateRankName::run(RankNameData::fromRequest($request));

        return redirect()
            ->route('ranks.names.index')
            ->withToast("{$name->name} rank name was created");
    }
}
