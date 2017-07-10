<?php namespace Nova\Auth\Http\Controllers;

use Controller;
use Nova\Users\User;
use Illuminate\Http\Request;
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

	public function login(Request $request)
	{
		$this->validateLogin($request);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if ($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		// Attempt the log in
		$attempt = $this->attemptLogin($request);

		// The only time we'll have a string response is from a forced reset
		if (is_string($attempt)) {
			return $this->sendResetPasswordLoginResponse($request);
		}
		
		if ($attempt) {
			return $this->sendLoginResponse($request);
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	protected function attemptLogin(Request $request)
	{
		// Get the user
		$user = User::where('email', $request->get('email'))->first();

		// Does the user have a null password? If so, time to reset...
		if ($user and $user->getPassword() == null) {
			return 'reset';
			return $this->sendResetPasswordLoginResponse($request);
		}

		return $this->guard()->attempt(
			$this->credentials($request),
			$request->has('remember')
		);
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

	protected function sendLoginResponse(Request $request)
	{
		flash()->message(_m('auth-success', [auth()->user()->present()->name]))->success();

		$request->session()->regenerate();

		$this->clearLoginAttempts($request);

		return $this->authenticated($request, $this->guard()->user())
				?: redirect()->intended($this->redirectPath());
	}

	protected function sendResetPasswordLoginResponse(Request $request)
	{
		flash()
			->title(_m('auth-required-reset'))
			->message(_m('auth-required-reset-explain'))
			->warning();

		$this->clearLoginAttempts($request);

		return redirect()->route('password.request');
	}
}
