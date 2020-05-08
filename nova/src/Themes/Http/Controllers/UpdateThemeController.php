<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\UpdateTheme;
use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Themes\Http\Requests\UpdateThemeRequest;
use Nova\Themes\Http\Responses\UpdateThemeResponse;

class UpdateThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function showForm(Theme $theme)
    {
        $this->authorize('update', $theme);

        return app(UpdateThemeResponse::class)->with([
            'theme' => $theme,
        ]);
    }

    public function update(
        UpdateThemeRequest $request,
        UpdateTheme $action,
        Theme $theme
    ) {
        $this->authorize('update', $theme);

        $theme = $action->execute($theme, ThemeData::fromRequest($request));

        return redirect()
            ->route('themes.edit', $theme)
            ->withToast("{$theme->name} theme was updated.");
    }
}
