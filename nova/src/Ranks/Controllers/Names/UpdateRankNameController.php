<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Names;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\UpdateRankName;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Requests\UpdateRankNameRequest;
use Nova\Ranks\Responses\Names\UpdateRankNameResponse;

class UpdateRankNameController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(RankName $name)
    {
        $this->authorize('update', $name);

        return UpdateRankNameResponse::sendWith([
            'name' => $name->load('ranks.group'),
        ]);
    }

    public function update(UpdateRankNameRequest $request, RankName $name)
    {
        $this->authorize('update', $name);

        $name = UpdateRankName::run($name, RankNameData::from($request));

        return back()->withToast("{$name->name} was updated");
    }
}
