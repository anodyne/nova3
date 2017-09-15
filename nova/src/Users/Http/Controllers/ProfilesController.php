<?php namespace Nova\Users\Http\Controllers;

use Controller;
use Nova\Users\User;
use Illuminate\Contracts\Hashing\Hasher;

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

	public function edit()
	{
		$user = auth()->user();

		$this->authorize('updateProfile', $user);

		$genders = [
			'male' => _m('users-gender-option-male'),
			'female' => _m('users-gender-option-female'),
			'neutral' => _m('users-gender-option-neutral'),
		];

		return view('pages.users.edit-profile', compact('user', 'genders'));
	}

	public function update()
	{
		$user = auth()->user();

		$this->authorize('updateProfile', $user);

		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|email'
		], [
			'name.required' => _m('users-validation-name'),
			'email.required' => _m('users-validation-email-required'),
			'email.email' => _m('users-validation-email-email')
		]);

		updater(User::class)->with(request()->all())->update($user);

		flash()
			->title(_m('users-profile-flash-profile-updated-title'))
			->message(_m('users-profile-flash-profile-updated-message'))
			->success();

		return back();
	}

	public function updatePassword(Hasher $hasher)
	{
		$user = auth()->user();

		$this->authorize('updateProfile', $user);

		if (! $hasher->check(request('password_current'), $user->getPassword())) {
			flash()->message(_m('users-profile-validation-current-password'))->error();

			return back();
		}

		$this->validate(request(), [
			'password_current' => 'required',
			'password_new' => 'required|confirmed|min:6'
		], [
			'password_current.required' => _m('users-validation-password-required'),
			'password_new.required' => _m('users-validation-password-required'),
			'password_new.confirmed' => _m('users-validation-password-confirmed'),
			'password_new.min' => _m('users-validation-password-min'),
		]);

		updater(User::class)
			->with(['password' => request('password_new')])
			->update($user);

		flash()
			->title(_m('users-profile-flash-password-updated-title'))
			->message(_m('users-profile-flash-password-updated-message'))
			->success();

		return redirect()->route('profile.show', $user);
	}
}
