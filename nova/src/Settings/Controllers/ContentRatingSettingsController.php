<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Responses\ContentRatingSettingsResponse;

class ContentRatingSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', settings());

        return ContentRatingSettingsResponse::send();
    }
}
