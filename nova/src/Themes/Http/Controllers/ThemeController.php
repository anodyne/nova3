<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Jobs;
use Nova\Themes\Theme;
use Nova\Themes\Events;
use Nova\Themes\Http\Responses;
use Nova\Themes\Http\Requests\EditThemeRequest;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Themes\Http\Requests\CreateThemeRequest;

class ThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index()
    {
        return app(Responses\ManageThemesResponse::class)
            ->withThemes(Theme::get());
    }

    public function create()
    {
        return app(Responses\CreateThemeResponse::class);
    }

    public function store(CreateThemeRequest $request)
    {
        $theme = dispatch_now(new Jobs\CreateThemeJob($request->validated()));

        event(new Events\ThemeCreated($theme));

        alert()
            ->withTitle('Success!')
            ->withMessage('Theme was successfully created.')
            ->success();

        return redirect()->route('themes.index');
    }

    public function edit(Theme $theme)
    {
        return app(Responses\EditThemeResponse::class)
            ->withTheme($theme);
    }

    public function update(EditThemeRequest $request, Theme $theme)
    {
        $theme = dispatch_now(new Jobs\UpdateThemeJob($theme, $request->validated()));

        event(new Events\ThemeUpdated($theme->fresh()));

        alert()
            ->withTitle('Success!')
            ->withMessage('Theme was successfully updated.')
            ->success();

        return redirect()->route('themes.index');
    }

    public function destroy(Theme $theme)
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