<?php

namespace Nova\Settings\Http\Controllers;

use Nova\Foundation\Http\Controllers\Controller;
use Nova\Settings\Http\Responses\SettingsResponse;

class SettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index()
    {
        return app(SettingsResponse::class);
    }
}
