<?php

namespace Nova\Dashboard\Http\Controllers;

use Mail;
use Nova\Foundation\SystemInfo;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Dashboard\Http\Responses\DashboardResponse;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index()
    {
        return app(DashboardResponse::class);
    }

    public function characters()
    {
        $this->views('dashboard.characters');

        $this->setPageTitle(_m('dashboard-characters'));

        $this->user->loadMissing('characters.positions');

        $this->data->characters = $this->user->characters;
    }

    public function finishInstallation()
    {
        $this->renderWithTheme = false;

        // Set the install phase to 2
        SystemInfo::first()->setPhase('install', 2);
    }

    public function finishMigration()
    {
        $this->renderWithTheme = false;

        // Set the install and migrate phases to 2
        SystemInfo::first()->setPhase('install', 2);
        SystemInfo::first()->setPhase('migration', 2);

        // Send the email to the active users
    }

    public function sendTestEmail()
    {
        $this->renderWithTheme = false;

        Mail::to(request()->user()->email)
            ->queue(new \Nova\Dashboard\Mail\SendTestEmail);
    }
}
