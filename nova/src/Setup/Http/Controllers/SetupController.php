<?php namespace Nova\Setup\Http\Controllers;

class SetupController extends Controller {

	public function index()
	{
		/*if (app('nova.setup')->isInstalled())
		{
			return Redirect::route('setup.update');
		}*/

		return view('pages.setup.index');
	}

	public function environment()
	{
		$env = app('nova.setup')->checkEnvironment();

		if ($env->get('passes'))
			return redirect()->route('setup.home');

		return view('pages.setup.environment', compact('env'));
	}

}
