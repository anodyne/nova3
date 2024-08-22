<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Actions\UpdateEnvironment;
use Nova\Settings\Responses\EnvironmentSettingsResponse;

class EnvironmentSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', $settings = settings());

        return EnvironmentSettingsResponse::send();
    }

    public function update(Request $request)
    {
        $this->authorize('update', settings());

        UpdateEnvironment::run($request);

        return redirect()
            ->route('admin.settings.environment.edit')
            ->notify('Environment settings have been updated');
    }
}
