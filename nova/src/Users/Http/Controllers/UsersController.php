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

		$users = User::withTrashed()->get();

		return view('pages.users.all-users', compact('users', 'userClass'));
	}

	public function create()
	{
		$this->authorize('create', new User);

		$roles = Role::with('permissions')->get();

		return view('pages.users.create-user', compact('roles'));
	}

	public function store()
	{
		$this->authorize('create', new User);

		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|email|unique:users'
		], [
			'name.required' => _m('user-validation-name'),
			'email.required' => _m('user-validation-email-required'),
			'email.email' => _m('user-validation-email-email'),
			'email.unique' => _m('user-validation-email-unique')
		]);

		creator(User::class)->with(request()->all())->adminCreate();

		flash()
			->title(_m('user-flash-added-title'))
			->message(_m('user-flash-added-message'))
			->success();

		return redirect()->route('users.index');
	}

	public function edit(User $user)
	{
		$this->authorize('update', $user);

		$roles = Role::with('permissions')->get();

		return view('pages.users.update-user', compact('user', 'roles'));
	}

	public function update(User $user)
	{
		$this->authorize('update', $user);

		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|email'
		], [
			'name.required' => _m('user-validation-name'),
			'email.required' => _m('user-validation-email-required'),
			'email.email' => _m('user-validation-email-email')
		]);

		updater(User::class)->with(request()->all())->update($user);

		flash()
			->title(_m('user-flash-updated-title'))
			->message(_m('user-flash-updated-message'))
			->success();

		return redirect()->route('users.index');
	}

	public function destroy(User $user)
	{
		$this->authorize('delete', $user);

		deletor(User::class)->delete($user);

		flash()
			->title(_m('user-flash-deleted-title'))
			->message(_m('user-flash-deleted-message'))
			->success();

		return redirect()->route('users.index');
	}

	public function restore(User $user)
	{
		$this->authorize('update', $user);

		restorer(User::class)->restore($user);

		flash()
			->title(_m('user-flash-restored-title'))
			->message(_m('user-flash-restored-message'))
			->success();

		return redirect()->route('users.index');
	}
}
