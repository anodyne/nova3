<?php namespace Nova\Authorize\Http\Controllers;

use Controller;
use Nova\Authorize\Role;
use Nova\Authorize\Permission;

class RolesController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$roleClass = new Role;
		$permissionClass = new Permission;

		$this->authorize('manage', $roleClass);

		$roles = cache('nova.roles');

		return view('pages.authorize.all-roles', compact('roles', 'roleClass', 'permissionClass'));
	}

	public function create()
	{
		$this->authorize('create', new Role);

		$permissions = cache('nova.permissions');

		return view('pages.authorize.create-role', compact('permissions'));
	}

	public function store()
	{
		$this->authorize('create', new Role);

		$this->validate(request(), [
			'name' => 'required'
		], [
			'name.required' => _m('validation-name-required')
		]);

		creator(Role::class)->with(request()->all())->create();

		flash()
			->title(_m('authorize-roles-flash-added-title'))
			->message(_m('authorize-roles-flash-added-message'))
			->success();

		return redirect()->route('roles.index');
	}

	public function edit(Role $role)
	{
		$this->authorize('update', $role);

		$role->loadMissing('permissions');

		$permissions = cache('nova.permissions');

		return view('pages.authorize.update-role', compact('role', 'permissions'));
	}

	public function update(Role $role)
	{
		$this->authorize('update', $role);

		$this->validate(request(), [
			'name' => 'required'
		], [
			'name.required' => _m('validation-name-required')
		]);

		updater(Role::class)->with(request()->all())->update($role);

		flash()
			->title(_m('authorize-roles-flash-updated-title'))
			->message(_m('authorize-roles-flash-updated-message'))
			->success();

		return redirect()->route('roles.index');
	}

	public function destroy(Role $role)
	{
		$this->authorize('delete', $role);

		deletor(Role::class)->delete($role);

		return response($role, 200);
	}
}
