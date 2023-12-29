<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Models\NotificationType;
use Nova\Settings\Responses\NotificationSettingsResponse;

class NotificationSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', $settings = settings());

        return NotificationSettingsResponse::sendWith([
            'settings' => $settings->posting_activity,
            'notificationTypes' => NotificationType::get(),
        ]);
    }
}
