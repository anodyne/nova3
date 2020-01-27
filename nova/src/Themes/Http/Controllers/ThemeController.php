<?php

namespace Nova\Themes\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Themes\Models\Theme;
use Nova\Themes\Http\Requests;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Themes\Actions\UpdateTheme;
use Nova\Themes\Http\Resources\ThemeResource;
use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Themes\Http\Resources\ThemeCollection;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Themes\Http\Responses\EditThemeResponse;
use Nova\Themes\Http\Responses\ViewThemeResponse;
use Nova\Themes\Http\Responses\ThemeIndexResponse;
use Nova\Themes\Http\Responses\CreateThemeResponse;

class ThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Theme::class);
    }

    public function index(Request $request)
    {
        $themes = Theme::orderBy('name')
            ->filter($request->only('search'))
            ->paginate();

        return app(ThemeIndexResponse::class)->with([
            'filters' => $request->all('search'),
            'themes' => new ThemeCollection($themes),
        ]);
    }

    public function show(Theme $theme)
    {
        return app(ViewThemeResponse::class)->with([
            'theme' => new ThemeResource($theme),
        ]);
    }

    public function create()
    {
        return app(CreateThemeResponse::class);
    }

    public function store(Requests\Store $request, CreateTheme $action)
    {
        return $action->execute(ThemeData::fromRequest($request));
    }

    public function edit(Theme $theme)
    {
        return app(EditThemeResponse::class)->with([
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
