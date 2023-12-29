<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Actions\UpdateEmail;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\Email;
use Nova\Settings\Responses\EmailSettingsResponse;

class EmailSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', $settings = settings());

        return EmailSettingsResponse::sendWith([
            'settings' => $settings->email,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', settings());

        UpdateSettings::run('email', $data = Email::from($request));

        UpdateEmail::run($data, $request);

        return redirect()
            ->route('settings.email.edit')
            ->notify('Email settings have been updated');
    }
}
