<?php

namespace Nova\Settings\Controllers;

use Nova\Themes\Models\Theme;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Responses\SettingsResponse;

class SettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index($tab = 'general')
    {
        return app(SettingsResponse::class)->with([
            'tab' => $tab,
            'themes' => Theme::whereActive()->orderBy('name')->get(),
        ]);
    }

    public function update()
    {
        return back()->withToast('Welcome back!');
    }
}
