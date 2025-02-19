<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\WritingDashboard;
use Nova\Settings\Responses\WritingDashboardSettingsResponse;

class WritingDashboardSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', $settings = settings());

        return WritingDashboardSettingsResponse::sendWith([
            'settings' => $settings->writing_dashboard,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', settings());

        UpdateSettings::run('writing_dashboard', WritingDashboard::from($request));

        return back()->notify('Writing dashboard settings have been updated');
    }
}
