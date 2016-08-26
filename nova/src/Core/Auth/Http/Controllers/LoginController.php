<?php namespace Nova\Core\Auth\Http\Controllers;

use Date, BaseController, UserRepositoryContract;
use Nova\Core\Auth\Events;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends BaseController {

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
		$name = $user->present()->firstName;

		event(new Events\LoggedIn($user, Date::now()));

		flash()->success("Welcome back, {$name}!", "You are now logged in.");
	}

	protected function sendFailedLoginResponse(Request $request)
	{
		// Grab the user that's trying to log in
		$user = $this->userRepo->getFirstBy('email', $request->get($this->username()));

		// If the user's password is completely empty, an admin is forcing them
		// to reset their password, so let's kick them over to the reset page
		// with a message to tell them what's happening.
		if ($user and $user->password === null)
		{
			$message = "An administrator has required you to reset your password before you can continue.";

			event(new Events\PasswordResetRequired($user, Date::now()));

			session()->flash('password_reset_required', $message);

			flash()->warning('Password Reset Required', $message);

			return redirect()->route('password.email.show');
		}

		event(new Events\LoginFailed($request->get('email'), Date::now()));

		flash()->error("Log In Failed!", "The email address or password don't match our records.");

		return redirect()->back()->withInput($request->only('email'));
	}

	protected function sendLockoutResponse(Request $request)
	{
		$seconds = $this->limiter()->availableIn(
			$this->throttleKey($request)
		);

		flash()->error("Too Many Attempts!", "You've attempted to log in too many times. Please try again in {$seconds} seconds.");

		return redirect()->back()
			->withInput($request->only($this->username(), 'remember'));
	}
}
