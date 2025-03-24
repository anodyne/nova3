<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Illuminate\Support\Facades\Auth;
use Nova\Foundation\Controllers\Controller;
use Nova\Users\Actions\BanUserManager;
use Nova\Users\Models\Ban;
use Nova\Users\Models\User;
use Nova\Users\Requests\StoreBanRequest;
use Nova\Users\Responses\CreateBanResponse;
use Nova\Users\Responses\ListBansResponse;
use Nova\Users\Responses\ShowBanResponse;

class BanController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Ban::class);
    }

    public function index()
    {
        return ListBansResponse::send();
    }

    public function show(Ban $ban)
    {
        return ShowBanResponse::sendWith([
            'ban' => $ban->load('bannable', 'createdBy'),
        ]);
    }

    public function create()
    {
        return CreateBanResponse::sendWith([
            'users' => User::query()->active()->whereNotIn('id', [Auth::id()])->get(),
        ]);
    }

    public function store(StoreBanRequest $request)
    {
        $ban = BanUserManager::run($request->getBanData());

        $banString = $ban->bannable?->name ?? "the IP address {$ban->ip}";

        return to_route('admin.bans.index')
            ->notify("A ban was created for {$banString}");
    }
}
