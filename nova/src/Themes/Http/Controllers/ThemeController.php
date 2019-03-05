<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Jobs;
use Nova\Themes\Theme;
use Nova\Themes\Events;
use Nova\Themes\Http\Responses;
use Nova\Themes\Http\Authorizers;
use Symfony\Component\HttpFoundation\Response;
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

    public function index(Authorizers\Index $authorize)
    {
        $themes = Theme::get();

        return app(Responses\ManageThemesResponse::class)
            ->withThemes($themes)
            ->withPendingThemes($themes->toBeInstalled())
            ->withCan($authorize->userPermissions());
    }

    public function create()
    {
        return app(Responses\CreateThemeResponse::class);
    }

    public function store(CreateThemeRequest $request)
    {
        $theme = dispatch_now(new Jobs\CreateThemeJob($request->validated()));

        event(new Events\ThemeCreated($theme));

        return response()->json($theme, Response::HTTP_CREATED);
    }

    public function edit(Theme $theme)
    {
        return app(Responses\EditThemeResponse::class)
            ->withTheme($theme);
    }

    public function update(EditThemeRequest $request, Theme $theme)
    {
        $theme = dispatch_now(new Jobs\EditThemeJob($theme, $request->validated()));

        event(new Events\ThemeUpdated($theme->fresh()));

        return response()->json($theme->fresh(), Response::HTTP_OK);
    }

    public function destroy(Theme $theme)
    {
        $theme = dispatch_now(new Jobs\DeleteThemeJob($theme));

        event(new Events\ThemeDeleted($theme));

        return response()->json($theme, Response::HTTP_NO_CONTENT);
    }
}
