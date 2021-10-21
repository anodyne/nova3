<?php

declare(strict_types=1);

namespace Nova\Themes\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Themes\Models\Theme;
use Nova\Themes\Responses\DeleteThemeResponse;

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

        return DeleteThemeResponse::sendWith([
            'theme' => $theme,
        ]);
    }

    public function destroy(Theme $theme)
    {
        $this->authorize('delete', $theme);

        DeleteTheme::run($theme);

        return redirect()
            ->route('themes.index')
            ->withToast("{$theme->name} theme was uninstalled", 'Theme files have not been deleted from the server.');
    }
}
