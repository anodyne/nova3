<?php

declare(strict_types=1);

namespace Nova\Themes\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Themes\Actions\CreateThemeManager;
use Nova\Themes\Actions\UpdateTheme;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Models\Theme;
use Nova\Themes\Requests\StoreThemeRequest;
use Nova\Themes\Requests\UpdateThemeRequest;
use Nova\Themes\Responses\CreateThemeResponse;
use Nova\Themes\Responses\EditThemeResponse;
use Nova\Themes\Responses\ListThemesResponse;
use Nova\Themes\Responses\ShowThemeResponse;

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
        $themes = Theme::orderBy('name')->get();

        return ListThemesResponse::sendWith([
            'themes' => ($request->has('pending')) ? $themes->onlyPending() : $themes->withPending(),
        ]);
    }

    public function show(Theme $theme)
    {
        return ShowThemeResponse::sendWith([
            'theme' => $theme,
        ]);
    }

    public function create()
    {
        return CreateThemeResponse::send();
    }

    public function store(StoreThemeRequest $request)
    {
        $theme = CreateThemeManager::run($request);

        return redirect()
            ->route('themes.index')
            ->notify("{$theme->name} theme was created", 'A folder has been created in the themes directory to help you get started creating your theme.');
    }

    public function edit(Theme $theme)
    {
        return EditThemeResponse::sendWith([
            'theme' => $theme,
        ]);
    }

    public function update(UpdateThemeRequest $request, Theme $theme)
    {
        $theme = UpdateTheme::run($theme, ThemeData::from($request));

        return redirect()
            ->route('themes.edit', $theme)
            ->notify("{$theme->name} theme was updated");
    }
}
