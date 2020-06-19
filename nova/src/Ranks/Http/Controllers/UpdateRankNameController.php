<?php

namespace Nova\Ranks\Http\Controllers;

use Nova\Ranks\Models\RankName;
use Nova\Ranks\Actions\UpdateRankName;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Ranks\DataTransferObjects\RankNameData;
use Nova\Ranks\Http\Requests\UpdateRankNameRequest;
use Nova\Ranks\Http\Responses\UpdateRankNameResponse;

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

        return app(UpdateRankNameResponse::class)->with([
            'name' => $name,
        ]);
    }

    public function update(
        UpdateRankNameRequest $request,
        UpdateRankName $action,
        RankName $name
    ) {
        $this->authorize('update', $name);

        $name = $action->execute($name, RankNameData::fromRequest($request));

        return back()->withToast("{$name->name} was updated");
    }
}
