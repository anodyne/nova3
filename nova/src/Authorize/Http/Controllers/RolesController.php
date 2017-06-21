<?php namespace Nova\Authorize\Http\Controllers;

use Nova\Authorize\Role;
use Illuminate\Http\Request;
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

	public function store(Request $request)
	{
		$this->authorize('create', new Role);

		$this->validate($request, [
			'name' => 'required'
		], [
			'name.required' => _m('authorize-role-validation-name')
		]);

		Role::create($request->all());

		return redirect()->route('roles.index');
	}

	public function edit(Role $role)
	{
		$this->authorize('update', $role);

		$role->load('permissions');

		$permissions = Permission::get();

		return view('pages.authorize.update-role', compact('role', 'permissions'));
	}

	public function update(Request $request, Role $role)
	{
		$this->authorize('update', $role);

		$this->validate($request, [
			'name' => 'required'
		], [
			'name.required' => _m('authorize-role-validation-name')
		]);

		$role->update($request->all());

		return redirect()->route('roles.index');
	}

	public function destroy(Role $role)
	{
		$this->authorize('delete', $role);

		$role->delete();

		return redirect()->route('roles.index');
	}
}
