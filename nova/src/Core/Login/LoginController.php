<?php namespace Nova\Core\Login;

use Flash, Input, BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard,
	Illuminate\Contracts\Foundation\Application;

class LoginController extends BaseController {

	protected $auth;

	public function __construct(Application $app, Guard $auth)
	{
		parent::__construct($app);

		$this->auth = $auth;
		$this->structureView = 'login';
		$this->templateView = 'login';
	}

	public function index()
	{
		$this->view = 'login/index';
	}

	public function login(Request $request)
	{
		// Validate the request
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		// Grab the credentials out of the request
		$credentials = $request->only('email', 'password');

		// Remember the user?
		$remember = true;

		if ($this->auth->attempt($credentials, $remember))
		{
			return redirect()->intended(route('home'));
		}

		Flash::error("Log in failed");

		return redirect()->back()
			->withInput($request->only('email'))
			->withErrors([
				'email' => 'These credentials do not match our records.',
			]);
	}

	public function logout()
	{
		$this->auth->logout();

		return redirect()->route('home');
	}

}
