<?php namespace Nova\Users\Http\Controllers;

use Controller;
use Nova\Users\User;
use Nova\Users\Events\AdminForcedPasswordReset;

class ForcePasswordResetsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$this->authorize('update', new User);

		$users = User::active()->get();

		return view('pages.users.force-password-resets', compact('users'));
	}

	public function update()
	{
		$this->authorize('update', new User);

		// Get all of the users we're targeting
		$users = User::whereIn('id', request('users'))->get();

		// Reset the passwords
		$users->each->update([
			'password' => null,
			'remember_token' => null
		]);

		// Get an array of email addresses
		$recipients = $users->map(function ($user) {
			return $user->email;
		})->all();

		// Notify the users that they have to reset their password
		$event = event(new AdminForcedPasswordReset($recipients));

		flash()
			->title(_m('users-flash-password-reset-title'))
			->message(_m('users-flash-password-reset-message'))
			->success();

		return back();
	}
}
