<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Jobs;
use Nova\Themes\Theme;
use Nova\Themes\Events;
use Illuminate\Http\Response;
use Nova\Themes\Http\Requests;
use Nova\Themes\Http\Responses;
use Nova\Themes\Http\Authorizers;
use Nova\Foundation\Http\Controllers\Controller;

class ThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index(Authorizers\Index $auth)
    {
        $themes = Theme::get();

        return app(Responses\Index::class)
            ->withThemes($themes)
            ->withPendingThemes($themes->toBeInstalled())
            ->withCan($auth->userAbilities());
    }

    public function create(Authorizers\Create $auth)
    {
        return app(Responses\Create::class);
    }

    public function store(Authorizers\Store $auth, Requests\Store $request)
    {
        $theme = dispatch_now(new Jobs\CreateTheme($request->validated()));

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
        $theme = dispatch_now(new Jobs\UpdateTheme($theme, $request->validated()));

        event(new Events\ThemeUpdated($theme->fresh()));

        return $theme->fresh();
    }

    public function destroy(Authorizers\Destroy $auth, Theme $theme)
    {
        $theme = dispatch_now(new Jobs\DeleteTheme($theme));

        event(new Events\ThemeDeleted($theme));

        return $theme;
    }
}
