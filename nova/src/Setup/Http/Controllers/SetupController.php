<?php namespace Nova\Setup\Http\Controllers;

use Artisan;

class SetupController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('nova.auth-setup')->except('showError');
	}

	public function index()
	{
		// Is Nova installed?
		$installed = nova()->isInstalled();

		// Is there an update available for Nova?
		$hasUpdate = nova()->hasUpdate();

		// If there is an update available, grab the info
		$update = ($hasUpdate) ? nova()->getLatestVersion() : false;

		return view('setup.start', compact('installed', 'update', 'hasUpdate'));
	}

	public function environment()
	{
		// Check the environment
		$env = app('nova')->checkEnvironment();

		// If everything checks out, head to the Setup Center
		if ($env->get('passes')) {
			return redirect()->route('setup.home');
		}

		return view('setup.environment', compact('env'));
	}

	public function showError($error)
	{
		switch ($error)
		{
			case 100:
				$title = 'Error!';
				$header = 'Operation Not Allowed';
				$message = "";
			break;

			case 200:
				$title = 'Error!';
				$header = 'Access Denied';
				$message = "You don't have the proper permissions to access the Setup Center!";

				// Log a message

				// Put a message into the Nova event log

				// Email the system administrators
			break;
		}

		return view('setup.error', compact('title', 'header', 'message'));
	}
}
