<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Models\Theme;
use Nova\Themes\Http\Requests;
use Nova\Themes\Http\Responses;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Themes\Actions\UpdateTheme;
use Nova\Themes\Http\Resources\ThemeResource;
use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Themes\Http\Resources\ThemeCollection;
use Nova\Foundation\Http\Controllers\Controller;

class ThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Theme::class);
    }

    public function index()
    {
        $themes = Theme::get();

        return app(Responses\Index::class)->with([
            'themes' => new ThemeCollection($themes),
            'pendingThemes' => $themes->toBeInstalled(),
        ]);
    }

    public function create()
    {
        return app(Responses\Create::class);
    }

    public function store(Requests\Store $request, CreateTheme $action)
    {
        return $action->execute(ThemeData::fromRequest($request));
    }

    public function edit(Theme $theme)
    {
        return app(Responses\Edit::class)->with([
            'theme' => new ThemeResource($theme),
        ]);
    }

    public function update(Requests\Update $request, UpdateTheme $action, Theme $theme)
    {
        return $action->execute($theme, ThemeData::fromRequest($request));
    }

    public function destroy(DeleteTheme $action, Theme $theme)
    {
        return $action->execute($theme);
    }
}
