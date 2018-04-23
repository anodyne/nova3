<?php namespace Nova\Users\Http\Controllers;

use Controller;
use Nova\Users\User;
use Nova\Authorize\Role;
use Nova\Characters\Character;

class UsersController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'template');
	}

	public function index()
	{
		$userClass = new User;

		$this->authorize('manage', $userClass);

		$this->views('users.all-users', 'page|script');

		$this->setPageTitle(_m('users', [2]));

		$this->data->userClass = $userClass;
		$this->data->characterClass = new Character;
		$this->data->users = User::with('characters')->withTrashed()->get();
	}

	public function create()
	{
		$this->authorize('create', new User);

		$this->views('users.create-user');

		$this->setPageTitle(_m('users-add'));

		$this->data->roles = Role::with('permissions')->get();
		$this->data->genders = [
			'male' => _m('users-gender-option-male'),
			'female' => _m('users-gender-option-female'),
			'neutral' => _m('users-gender-option-neutral'),
		];
	}

	public function store()
	{
		$this->renderWithTheme = false;

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

		$this->views('users.edit-user');

		$this->setPageTitle(_m('users-update'));

		$this->data->user = $user->loadMissing('characters.user', 'characters.positions', 'primaryCharacter.positions');
		$this->data->roles = Role::with('permissions')->get();
		$this->data->genders = [
			'male' => _m('users-gender-option-male'),
			'female' => _m('users-gender-option-female'),
			'neutral' => _m('users-gender-option-neutral'),
		];
	}

	public function update(User $user)
	{
		$this->renderWithTheme = false;

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
		$this->renderWithTheme = false;

		$this->authorize('delete', $user);

		deletor(User::class)->delete($user);

		return response($user, 200);
	}

	public function restore(User $user)
	{
		$this->renderWithTheme = false;

		$this->authorize('update', $user);

		restorer(User::class)->restore($user);

		return response($user, 200);
	}
}
