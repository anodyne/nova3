<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Jobs;
use Nova\Themes\Events;
use Nova\Themes\Models\Theme;
use Nova\Themes\Http\Responses;
use Nova\Themes\Http\Resources;
use Nova\Themes\Http\Validators;
use Nova\Themes\Http\Authorizors;
use Nova\Foundation\Http\Controllers\Controller;

class ThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index(Authorizors\Index $auth)
    {
        $themes = Theme::get();

        return app(Responses\Index::class)
            ->withThemes(new Resources\ThemeCollection($themes))
            ->withPendingThemes($themes->toBeInstalled());
    }

    public function create(Authorizors\Create $auth)
    {
        return app(Responses\Create::class);
    }

    public function store(Authorizors\Store $auth, Validators\Store $request)
    {
        $theme = dispatch_now(new Jobs\Create($request->validated()));

        return $theme->fresh();
    }

    public function edit(Authorizors\Edit $auth, Theme $theme)
    {
        return app(Responses\Edit::class)
            ->withTheme(new Resources\ThemeResource($theme));
    }

    public function update(Authorizors\Update $auth, Validators\Update $request, Theme $theme)
    {
        $theme = dispatch_now(new Jobs\Update($theme, $request->validated()));

        return $theme->fresh();
    }

    public function destroy(Authorizors\Destroy $auth, Theme $theme)
    {
        $theme = dispatch_now(new Jobs\Delete($theme));

        return $theme;
    }
}
