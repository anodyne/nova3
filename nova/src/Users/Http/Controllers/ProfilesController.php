<?php namespace Nova\Users\Http\Controllers;

use Controller;
use Nova\Users\User;
use Illuminate\Http\Request;
use Nova\Users\UserRepository;

class ProfilesController extends Controller
{
	protected $usersRepo;

	public function __construct(UserRepository $usersRepo)
	{
		parent::__construct();

		$this->middleware('auth');

		$this->usersRepo = $usersRepo;
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
}
