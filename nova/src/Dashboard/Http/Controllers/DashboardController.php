<?php namespace Nova\Dashboard\Http\Controllers;

use Controller;
use Nova\Foundation\SystemInfo;

class DashboardController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$sysinfo = SystemInfo::first();

		return view('pages.dashboard.index', compact('sysinfo'));
	}

	public function characters()
	{
		$this->user->loadMissing('characters.positions');

		$characters = $this->user->characters;

		return view('pages.dashboard.characters', compact('characters'));
	}

	public function finishInstallation()
	{
		// Set the install phase to 2
		SystemInfo::first()->setPhase('install', 2);
	}

	public function finishMigration()
	{
		// Set the install and migrate phases to 2
		SystemInfo::first()->setPhase('install', 2);
		SystemInfo::first()->setPhase('migration', 2);

		// Send the email to the active users
	}

	public function sendTestEmail()
	{
		//
	}
}
