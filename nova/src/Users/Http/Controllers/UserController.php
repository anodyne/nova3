<?php

namespace Nova\Users\Http\Controllers;

use Nova\Users\User;
use Nova\Users\Jobs;
use Nova\Users\Theme;
use Nova\Users\Events;
use Nova\Users\Http\Requests;
use Nova\Users\Http\Responses;
use Nova\Users\Http\Authorizers;
use Nova\Foundation\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index(Authorizers\Index $auth)
    {
        $users = User::get();

        return app(Responses\Index::class)
            ->withUsers($users)
            ->withPendingUsers($users->pending());
    }

    public function create(Authorizers\Create $auth)
    {
        return app(Responses\Create::class);
    }

    public function store(Authorizers\Store $auth, Requests\Store $request)
    {
        $theme = dispatch_now(new Jobs\CreateThemeJob($request->validated()));

        event(new Events\ThemeCreated($theme));

        return $theme->fresh();
    }

    public function edit(Authorizers\Edit $auth, Theme $theme)
    {
        return app(Responses\Edit::class)
            ->withTheme($theme);
    }

    public function update(Authorizers\Update $auth, Requests\Update $request, Theme $theme)
    {
        $theme = dispatch_now(new Jobs\EditThemeJob($theme, $request->validated()));

        event(new Events\ThemeUpdated($theme->fresh()));

        return $theme->fresh();
    }

    public function destroy(Authorizers\Destroy $auth, Theme $theme)
    {
        $theme = dispatch_now(new Jobs\DeleteThemeJob($theme));

        event(new Events\ThemeDeleted($theme));

        return $theme;
    }
}
