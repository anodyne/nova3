<?php

namespace Nova\Settings\Http\Controllers;

use Nova\Themes\Models\Theme;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Settings\Http\Responses\SettingsResponse;

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
