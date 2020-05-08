<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Foundation\Http\Controllers\Controller;

class DeleteThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(DeleteTheme $action, Theme $theme)
    {
        $this->authorize('delete', $theme);

        return $action->execute($theme);
    }
}
