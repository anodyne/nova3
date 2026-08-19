<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\Dashboard;
use Nova\Settings\Responses\DashboardSettingsResponse;

class DashboardSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(): Responsable
    {
        $this->authorize('update', $settings = settings());

        return DashboardSettingsResponse::sendWith([
            'settings' => $settings->dashboard,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', settings());

        UpdateSettings::run('dashboard', Dashboard::from($request));

        return back()->notify('Dashboard settings have been updated');
    }
}
