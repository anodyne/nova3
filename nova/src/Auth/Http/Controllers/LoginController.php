<?php namespace Nova\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
	use AuthenticatesUsers;

	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('guest')->except('logout');
	}

	public function showLoginForm()
	{
		return view('pages.auth.login');
	}

	public function redirectTo()
	{
		return route('home');
	}

	protected function sendFailedLoginResponse(Request $request)
	{
		$errors = [$this->username() => _m('auth-validation-credentials')];

		if ($request->expectsJson()) {
			return response()->json($errors, 422);
		}

		return back()
			->withInput($request->only($this->username()))
			->withErrors($errors);
	}

	protected function sendLockoutResponse(Request $request)
	{
		$seconds = $this->limiter()->availableIn(
			$this->throttleKey($request)
		);

		$errors = [$this->username() => _m('auth-attempts', [1 => $seconds])];

		if ($request->expectsJson()) {
			return response()->json($errors, 423);
		}

		return back()
			->withInput($request->only($this->username()))
			->withErrors($errors);
	}
}
