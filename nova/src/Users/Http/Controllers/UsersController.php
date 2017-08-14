<?php namespace Nova\Users\Http\Controllers;

use Controller;
use Nova\Users\User;
use Nova\Authorize\Role;

class UsersController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$userClass = new User;

		$this->authorize('manage', $userClass);

		$users = User::with('characters')->withTrashed()->get();

		return view('pages.users.all-users', compact('users', 'userClass'));
	}

	public function create()
	{
		$this->authorize('create', new User);

		$roles = Role::with('permissions')->get();

		$genders = [
			'male' => _m('users-gender-option-male'),
			'female' => _m('users-gender-option-female'),
			'neutral' => _m('users-gender-option-neutral'),
		];

		return view('pages.users.create-user', compact('roles', 'genders'));
	}

	public function store()
	{
		$this->authorize('create', new User);

		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|email|unique:users'
		], [
			'name.required' => _m('validation-name-required'),
			'email.required' => _m('users-validation-email-required'),
			'email.email' => _m('users-validation-email-email'),
			'email.unique' => _m('users-validation-email-unique')
		]);

		creator(User::class)->with(request()->all())->adminCreate();

		flash()
			->title(_m('users-flash-added-title'))
			->message(_m('users-flash-added-message'))
			->success();

		return redirect()->route('users.index');
	}

	public function edit(User $user)
	{
		$this->authorize('update', $user);

		$roles = Role::with('permissions')->get();

		$genders = [
			'male' => _m('users-gender-option-male'),
			'female' => _m('users-gender-option-female'),
			'neutral' => _m('users-gender-option-neutral'),
		];

		return view('pages.users.update-user', compact('user', 'roles', 'genders'));
	}

	public function update(User $user)
	{
		$this->authorize('update', $user);

		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|email'
		], [
			'name.required' => _m('validation-name-required'),
			'email.required' => _m('users-validation-email-required'),
			'email.email' => _m('users-validation-email-email')
		]);

		updater(User::class)->with(request()->all())->update($user);

		flash()
			->title(_m('users-flash-updated-title'))
			->message(_m('users-flash-updated-message'))
			->success();

		return redirect()->route('users.index');
	}

	public function destroy(User $user)
	{
		$this->authorize('delete', $user);

		deletor(User::class)->delete($user);

		return response($user, 200);
	}

	public function restore(User $user)
	{
		$this->authorize('update', $user);

		restorer(User::class)->restore($user);

		return response($user, 200);
	}
}
