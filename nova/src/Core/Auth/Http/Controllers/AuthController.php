<?php namespace Nova\Core\Auth\Http\Controllers;

use BaseController,
	UserRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends BaseController {

	protected $auth;
	protected $userRepo;

	public function __construct(Guard $auth, UserRepositoryContract $users)
	{
		parent::__construct();

		$this->views->put('structure', 'auth');
		$this->views->put('template', 'auth');

		$this->auth = $auth;
		$this->userRepo = $users;
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

		// Grab the user that's trying to log in
		$user = $this->userRepo->getFirstBy('email', $request->get('email'));

		// If the user's password is completely empty, an admin is forcing them
		// to reset their password, so let's kick them over to the reset page
		// with a message to tell them what's happening.
		if ($user->password === null)
		{
			$message = "An administrator has required you to reset your password before you can continue.";

			event(new Events\PasswordResetRequired($user));

			session()->flash('password_reset_required', $message);

			flash()->warning('Password Reset Required', $message);

			return redirect()->route('password.email');
		}

		if ($this->auth->attempt($request->only('email', 'password'), true))
		{
			$name = user()->present()->firstName;

			event(new Events\LoggedIn(user()));

			flash()->success("Welcome back, {$name}!", "You are now logged in.");

			return redirect()->intended(route('home'));
		}

		event(new Events\LoginFailed($request->get('email')));

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
