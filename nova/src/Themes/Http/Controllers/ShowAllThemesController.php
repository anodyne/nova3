<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Models\Theme;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Themes\Http\Responses\ShowAllThemesResponse;

class ShowAllThemesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        $this->authorize('viewAny', Theme::class);

        return app(ShowAllThemesResponse::class)->with([
            'themes' => Theme::orderBy('name')->get()->withPending(),
        ]);
    }
}
