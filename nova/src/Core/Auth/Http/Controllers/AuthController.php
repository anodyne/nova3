<?php namespace Nova\Core\Auth\Http\Controllers;

use Flash, BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard,
	Illuminate\Contracts\Foundation\Application;

class AuthController extends BaseController {

	protected $auth;

	public function __construct(Application $app, Guard $auth)
	{
		parent::__construct($app);

		$this->auth = $auth;
		$this->structureView = 'auth';
		$this->templateView = 'auth';
	}

	public function getLogin()
	{
		$this->view = 'auth/login';
	}

	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required',
		]);

		// Grab the credentials out of the request
		$credentials = $request->only('email', 'password');

		// Remember the user?
		$remember = true;

		if ($this->auth->attempt($credentials, $remember))
		{
			$name = user()->present()->firstName;

			flash()->success("You are now logged in.", "Welcome back, {$name}!");

			return redirect()->intended(route('home'));
		}

		flash()->error("The email address or password don't match our records.", "Log In Failed!");

		return redirect()->back()->withInput($request->only('email'));
	}

	public function getLogout()
	{
		$this->auth->logout();

		flash()->success("You are now logged out.", "See ya later!");

		return redirect()->route('home');
	}

}
