<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Settings\Responses\EmailSettingsResponse;

class EmailSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(): Responsable
    {
        $this->authorize('update', settings());

        return EmailSettingsResponse::send();
    }
}
