<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Themes\Http\Responses\DeleteThemeConfirmationResponse;

class DeleteThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function showConfirmation(Theme $theme)
    {
        $this->authorize('delete', $theme);

        return app(DeleteThemeConfirmationResponse::class)->with([
            'theme' => $theme,
        ]);
    }

    public function destroy(DeleteTheme $action, Theme $theme)
    {
        $this->authorize('delete', $theme);

        $action->execute($theme);

        return redirect()
            ->route('themes.index')
            ->withToast("{$theme->name} theme was deleted.");
    }
}
