<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\General;
use Nova\Settings\Responses\GeneralSettingsResponse;

class GeneralSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', $settings = settings());

        return GeneralSettingsResponse::sendWith([
            'settings' => $settings->general,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', settings());

        UpdateSettings::run('general', $data = General::from($request));

        return to_route('admin.settings.general.edit')
            ->notify('General settings have been updated');
    }
}
