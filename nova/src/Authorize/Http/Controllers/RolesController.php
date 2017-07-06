<?php namespace Nova\Authorize\Http\Controllers;

use Nova\Authorize\Role;
use Nova\Authorize\Permission;
use Nova\Foundation\Http\Controllers\Controller;

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

		$roles = Role::get();

		return view('pages.authorize.all-roles', compact('roles', 'roleClass', 'permissionClass'));
	}

	public function create()
	{
		$this->authorize('create', new Role);

		$permissions = Permission::get();

		return view('pages.authorize.create-role', compact('permissions'));
	}

	public function store()
	{
		$this->authorize('create', new Role);

		$this->validate(request(), [
			'name' => 'required'
		], [
			'name.required' => _m('authorize-role-validation-name')
		]);

		creator(Role::class)->with(request()->all())->create();

		flash()->success(
			_m('authorize-role-flash-added-title'),
			_m('authorize-role-flash-added-message')
		);

		return redirect()->route('roles.index');
	}

	public function edit(Role $role)
	{
		$this->authorize('update', $role);

		$role->load('permissions');

		$permissions = Permission::get();

		return view('pages.authorize.update-role', compact('role', 'permissions'));
	}

	public function update(Role $role)
	{
		$this->authorize('update', $role);

		$this->validate(request(), [
			'name' => 'required'
		], [
			'name.required' => _m('authorize-role-validation-name')
		]);

		updater(Role::class)->with(request()->all())->update($role);

		flash()->success(
			_m('authorize-role-flash-updated-title'),
			_m('authorize-role-flash-updated-message')
		);

		return redirect()->route('roles.index');
	}

	public function destroy(Role $role)
	{
		$this->authorize('delete', $role);

		deletor(Role::class)->delete($role);

		flash()->success(
			_m('authorize-role-flash-deleted-title'),
			_m('authorize-role-flash-deleted-message')
		);

		return redirect()->route('roles.index');
	}
}
