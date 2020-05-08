<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Themes\Http\Requests\CreateThemeRequest;
use Nova\Themes\Http\Responses\CreateThemeResponse;

class CreateThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function showForm()
    {
        $this->authorize('create', Theme::class);

        return app(CreateThemeResponse::class);
    }

    public function store(CreateThemeRequest $request, CreateTheme $action)
    {
        $this->authorize('create', Theme::class);

        $theme = $action->execute(ThemeData::fromRequest($request));

        return redirect()
            ->route('themes.index')
            ->withToast("{$theme->name} theme was created.");
    }
}
