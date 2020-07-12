<?php

namespace Nova\Themes\Controllers;

use Illuminate\Http\Request;
use Nova\Themes\Models\Theme;
use Nova\Foundation\Controllers\Controller;
use Nova\Themes\Responses\ShowAllThemesResponse;

class ShowThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request)
    {
        $this->authorize('viewAny', Theme::class);

        $themes = Theme::orderBy('name')->get();

        return app(ShowAllThemesResponse::class)->with([
            'themes' => ($request->has('pending')) ? $themes->onlyPending() : $themes->withPending(),
        ]);
    }
}
