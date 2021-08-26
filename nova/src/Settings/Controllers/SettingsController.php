<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Responses\SettingsResponse;
use Nova\Themes\Models\Theme;

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
            'settings' => app('nova.settings'),
            'tab' => $tab,
            'themes' => Theme::whereActive()->orderBy('name')->get(),
        ]);
    }

    public function update()
    {
        return back()->withToast('Welcome back!');
    }
}
