<?php

declare(strict_types=1);

namespace Nova\Themes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Themes\Actions\UpdateTheme;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Models\Theme;
use Nova\Themes\Requests\UpdateThemeRequest;
use Nova\Themes\Responses\UpdateThemeResponse;

class UpdateThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(Theme $theme)
    {
        $this->authorize('update', $theme);

        return UpdateThemeResponse::sendWith([
            'theme' => $theme,
        ]);
    }

    public function update(UpdateThemeRequest $request, Theme $theme)
    {
        $this->authorize('update', $theme);

        $theme = UpdateTheme::run($theme, ThemeData::from($request));

        return redirect()
            ->route('themes.edit', $theme)
            ->withToast("{$theme->name} theme was updated");
    }
}
