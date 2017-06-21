<?php namespace Nova\Authorize\Http\Controllers;

use Nova\Authorize\Role;
use Illuminate\Http\Request;
use Nova\Authorize\Permission;
use Nova\Foundation\Http\Controllers\Controller;

class PermissionsController extends Controller
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

		$this->authorize('manage', $permissionClass);

		$permissions = Permission::get();

		return view('pages.authorize.all-permissions', compact('permissions', 'roleClass', 'permissionClass'));
	}

	public function create()
	{
		$this->authorize('create', new Permission);

		return view('pages.authorize.create-permission');
	}

	public function store(Request $request)
	{
		$this->authorize('create', new Permission);

		$this->validate($request, [
			'name' => 'required',
			'key' => 'required'
		]);

		Permission::create($request->all());

		return redirect()->route('permissions.index');
	}

	public function edit(Permission $permission)
	{
		$this->authorize('update', $permission);

		return view('pages.authorize.update-permission', compact('permission'));
	}

	public function update(Request $request, Permission $permission)
	{
		$this->authorize('update', $permission);

		$this->validate($request, [
			'name' => 'required',
			'key' => 'required'
		]);

		$permission->fill($request->all())->save();

		return redirect()->route('permissions.index');
	}

	public function destroy(Permission $permission)
	{
		$this->authorize('delete', $permission);

		$permission->roles()->sync([]);
		
		$permission->delete();

		return redirect()->route('permissions.index');
	}
}
