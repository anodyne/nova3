<?php namespace Nova\Core\Auth\Http\Controllers;

use Date;
use UserRepositoryContract;
use Nova\Core\Auth\Events;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Nova\Foundation\Http\Controllers\NovaController;

class AuthController extends NovaController
{
	use AuthenticatesUsers;

	protected $userRepo;
	protected $redirectTo;

	public function __construct(UserRepositoryContract $userRepo)
	{
		parent::__construct();

		$this->userRepo = $userRepo;
		$this->redirectTo = route('home');

		$this->views->put('structure', 'auth');
		$this->views->put('template', 'auth');

		$this->middleware('guest', ['except' => 'logout']);
	}

	public function showLoginForm()
	{
		$this->views->put('page', 'auth/login');
	}

	protected function authenticated(Request $request, $user)
	{
		event(new Events\LoggedIn($user, Date::now()));

		flash()->success(_m('welcome-back', [$user->present()->firstName]), _m('auth-success'));
	}

	protected function sendFailedLoginResponse(Request $request)
	{
		// Grab the user that's trying to log in
		$user = $this->userRepo->getFirstBy('email', $request->get($this->username()));

		// If the user's password is completely empty, an admin is forcing them
		// to reset their password, so let's kick them over to the reset page
		// with a message to tell them what's happening.
		if ($user and $user->password === null) {
			$message = _m('auth-required-reset-explain');

			event(new Events\PasswordResetRequired($user, Date::now()));

			session()->flash('password_reset_required', $message);

			flash()->warning(_m('auth-required-reset'), $message);

			return redirect()->route('password.email.show');
		}

		event(new Events\LoginFailed($request->get('email'), Date::now()));

		flash()->error(_m('auth-failed'), _m('auth-failed-explain'));

		return back()->withInput($request->only('email'));
	}

	protected function sendLockoutResponse(Request $request)
	{
		$seconds = $this->limiter()->availableIn(
			$this->throttleKey($request)
		);

		flash()->error(_m('auth-attempts'), _m('auth-attempts-explain', [$seconds]));

		return back()
			->withInput($request->only($this->username(), 'remember'));
	}
}
