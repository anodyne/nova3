<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Jobs;
use Nova\Themes\Theme;
use Nova\Themes\Events;
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
        return app(Responses\Index::class)
            ->withThemes(Theme::get());
    }

    public function create(Authorizers\Create $auth)
    {
        return app(Responses\Create::class);
    }

    public function store(Authorizers\Store $auth, Requests\Store $request)
    {
        $theme = dispatch_now(new Jobs\CreateThemeJob($request->validated()));

        event(new Events\ThemeCreated($theme));

        alert()
            ->withMessage('Theme was successfully created.')
            ->success();

        return redirect()->route('themes.index');
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

        alert()
            ->withMessage('Theme was successfully updated.')
            ->success();

        return redirect()->route('themes.index');
    }

    public function destroy(Authorizers\Destroy $auth, Theme $theme)
    {
        $theme = dispatch_now(new Jobs\DeleteThemeJob($theme));

        event(new Events\ThemeDeleted($theme));

        alert()
            ->withTitle('Success!')
            ->withMessage('Theme was successfully deleted.')
            ->success();

        return response()->json($theme);
    }
}
