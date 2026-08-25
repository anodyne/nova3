<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers;

use Illuminate\Http\RedirectResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
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

    public function index(): Responsable
    {
        return ListRankNamesResponse::send();
    }

    public function show(RankName $name): Responsable
    {
        return ShowRankNameResponse::sendWith([
            'name' => $name->load('ranks.group'),
        ]);
    }

    public function create(): Responsable
    {
        return CreateRankNameResponse::send();
    }

    public function store(StoreRankNameRequest $request): RedirectResponse
    {
        $name = CreateRankName::run($request->getRankNameData());

        return to_route('admin.ranks.names.index')
            ->notify("{$name->name} rank name was created");
    }

    public function edit(RankName $name): Responsable
    {
        return EditRankNameResponse::sendWith([
            'name' => $name->load('ranks.group'),
        ]);
    }

    public function update(UpdateRankNameRequest $request, RankName $name): RedirectResponse
    {
        $name = UpdateRankName::run($name, $request->getRankNameData());

        return back()->notify("{$name->name} was updated");
    }
}
