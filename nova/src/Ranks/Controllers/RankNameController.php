<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\CreateRankName;
use Nova\Ranks\Actions\UpdateRankName;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Requests\StoreRankNameRequest;
use Nova\Ranks\Requests\UpdateRankNameRequest;
use Nova\Ranks\Responses\CreateRankNameResponse;
use Nova\Ranks\Responses\EditRankNameResponse;
use Nova\Ranks\Responses\ListRankNamesResponse;
use Nova\Ranks\Responses\ShowRankNameResponse;

class RankNameController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(RankName::class, 'name');
    }

    public function index()
    {
        return ListRankNamesResponse::send();
    }

    public function show(RankName $name)
    {
        return ShowRankNameResponse::sendWith([
            'name' => $name->load('ranks.group'),
        ]);
    }

    public function create()
    {
        return CreateRankNameResponse::send();
    }

    public function store(StoreRankNameRequest $request)
    {
        $name = CreateRankName::run($request->getRankNameData());

        return redirect()
            ->route('admin.ranks.names.index')
            ->notify("{$name->name} rank name was created");
    }

    public function edit(RankName $name)
    {
        return EditRankNameResponse::sendWith([
            'name' => $name->load('ranks.group'),
        ]);
    }

    public function update(UpdateRankNameRequest $request, RankName $name)
    {
        $name = UpdateRankName::run($name, $request->getRankNameData());

        return back()->notify("{$name->name} was updated");
    }
}
