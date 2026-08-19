<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Illuminate\Support\Facades\Auth;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Users\Actions\BanUserManager;
use Nova\Users\Models\Ban;
use Nova\Users\Models\User;
use Nova\Users\Requests\StoreBanRequest;
use Nova\Users\Responses\CreateBanResponse;
use Nova\Users\Responses\ListBansResponse;

class BanController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Ban::class);
    }

    public function create(): Responsable
    {
        return CreateBanResponse::sendWith([
            'users' => User::query()->active()->whereNotIn('id', [Auth::id()])->get(),
        ]);
    }

    public function index(): Responsable
    {
        return ListBansResponse::send();
    }

    public function store(StoreBanRequest $request)
    {
        $ban = BanUserManager::run($request->getBanData());

        $banString = $ban->bannable->name ?? "the IP address {$ban->ip}";

        return to_route('admin.bans.index')
            ->notify("A ban was created for {$banString}");
    }
}
