<?php

declare(strict_types=1);

namespace Nova\Themes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Themes\Actions\CreateThemeManager;
use Nova\Themes\Models\Theme;
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

        return CreateThemeResponse::send();
    }

    public function store(CreateThemeRequest $request)
    {
        $this->authorize('create', Theme::class);

        $theme = CreateThemeManager::run($request);

        return redirect()
            ->route('themes.index')
            ->withToast("{$theme->name} theme was created", 'A folder has been created in the themes directory to help you get started creating your theme.');
    }
}
