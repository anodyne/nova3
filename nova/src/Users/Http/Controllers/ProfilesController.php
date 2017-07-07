<?php namespace Nova\Users\Http\Controllers;

use Controller;
use Nova\Users\User;

class ProfilesController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function show(User $user)
	{
		$this->authorize('view', $user);

		return view('pages.users.profile', compact('user'));
	}

	public function edit(User $user)
	{
		$this->authorize('updateProfile', $user);

		return view('pages.users.update-profile', compact('user'));
	}

	public function update(User $user)
	{
		$this->authorize('updateProfile', $user);

		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|email'
		], [
			'name.required' => _m('user-validation-name'),
			'email.required' => _m('user-validation-email-required'),
			'email.email' => _m('user-validation-email-email')
		]);

		updater(User::class)->with(request()->all())->update($user);

		flash()->success(
			_m('user-flash-updated-title'),
			_m('user-flash-updated-message')
		);

		return back();
	}

	public function updatePassword(User $user)
	{
		$this->authorize('updateProfile', $user);

		// Make sure they entered their current password correctly
		if (bcrypt(request('password_current')) !== $user->password) {
			flash()->message(_m('user-profile-validation-current-password'))->error();

			return back();
		}

		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|email'
		], [
			'name.required' => _m('user-validation-name'),
			'email.required' => _m('user-validation-email-required'),
			'email.email' => _m('user-validation-email-email')
		]);

		updater(User::class)->with(request()->all())->update($user);

		flash()->success(
			_m('user-flash-updated-title'),
			_m('user-flash-updated-message')
		);

		return redirect()->route('profile.show', $this->user);
	}
}
