<?php

namespace Nova\Themes\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Themes\Models\Theme;
use Nova\Themes\Filters\ThemeFilters;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Themes\Http\Responses\ShowAllThemesResponse;

class ShowAllThemesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, ThemeFilters $filters)
    {
        $this->authorize('viewAny', Theme::class);

        $themes = Theme::filter($filters)->orderBy('name')->get();

        return app(ShowAllThemesResponse::class)->with([
            'themes' => ($request->has('pending')) ? $themes->onlyPending() : $themes->withPending(),
        ]);
    }
}
