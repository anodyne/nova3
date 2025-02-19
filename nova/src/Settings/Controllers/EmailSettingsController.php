<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Nova\Foundation\Controllers\Controller;
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
        $this->authorize('update', settings());

        return EmailSettingsResponse::send();
    }
}
