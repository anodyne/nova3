<?php namespace Nova\Core\Auth\Http\Controllers;

use BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends BaseController {

	protected $auth;

	public function __construct(Guard $auth)
	{
		parent::__construct();

		$this->views->put('structure', 'auth');
		$this->views->put('template', 'auth');

		$this->auth = $auth;
	}

	public function getLogin()
	{
		$this->views->put('page', 'auth/login');
	}

	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required',
		]);

		if ($this->auth->attempt($request->only('email', 'password'), true))
		{
			$name = user()->present()->firstName;

			flash()->success("Welcome back, {$name}!", "You are now logged in.");

			return redirect()->intended(route('home'));
		}

		flash()->error("Log In Failed!", "The email address or password don't match our records.");

		return redirect()->back()->withInput($request->only('email'));
	}

	public function getLogout()
	{
		$this->auth->logout();

		flash()->success("See ya later!", "You are now logged out.");

		return redirect()->route('home');
	}

}
