<?php

namespace Nova\Themes\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Themes\Http\Responses\DeleteThemeResponse;

class DeleteThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $theme = Theme::findOrFail($request->id);

        return app(DeleteThemeResponse::class)->with([
            'theme' => $theme,
        ]);
    }

    public function destroy(DeleteTheme $action, Theme $theme) {
        $this->authorize('delete', $theme);

        $action->execute($theme);

        return redirect()
            ->route('themes.index')
            ->withToast("{$theme->name} theme was uninstalled", 'Theme files have not been deleted from the server.');
    }
}
