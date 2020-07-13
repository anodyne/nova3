<?php

namespace Nova\Themes\Controllers;

use Nova\Themes\Models\Theme;
use Nova\Foundation\Controllers\Controller;
use Nova\Themes\Actions\CreateThemeManager;
use Nova\Themes\Requests\CreateThemeRequest;
use Nova\Themes\Responses\CreateThemeResponse;

class CreateThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', Theme::class);

        return app(CreateThemeResponse::class);
    }

    public function store(CreateThemeRequest $request, CreateThemeManager $action)
    {
        $this->authorize('create', Theme::class);

        $theme = $action->execute($request);

        return redirect()
            ->route('themes.index')
            ->withToast("{$theme->name} theme was created", 'A folder has been created in the themes directory to help you get started creating your theme.');
    }
}
