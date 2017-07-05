<?php namespace Nova\Authorize\Http\Controllers;

use Nova\Authorize\Role;
use Nova\Authorize\Permission;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Authorize\Repositories\PermissionRepositoryContract;

class PermissionsController extends Controller
{
	protected $repo;

	public function __construct(PermissionRepositoryContract $repo)
	{
		parent::__construct();

		$this->repo = $repo;

		$this->middleware('auth');
	}

	public function index()
	{
		$roleClass = new Role;
		$permissionClass = new Permission;

		$this->authorize('manage', $permissionClass);

		$permissions = $this->repo->all();

		return view('pages.authorize.all-permissions', compact('permissions', 'roleClass', 'permissionClass'));
	}

	public function create()
	{
		$this->authorize('create', new Permission);

		return view('pages.authorize.create-permission');
	}

	public function store()
	{
		$this->authorize('create', new Permission);

		$this->validate(request(), [
			'name' => 'required',
			'key' => 'required'
		], [
			'name.required' => _m('authorize-permission-validation-name'),
			'key.required' => _m('authorize-permission-validation-key')
		]);

		creator(Permission::class)->data(request()->all())->create();

		flash()->success(
			_m('authorize-permission-flash-added-title'),
			_m('authorize-permission-flash-added-message')
		);

		return redirect()->route('permissions.index');
	}

	public function edit(Permission $permission)
	{
		$this->authorize('update', $permission);

		return view('pages.authorize.update-permission', compact('permission'));
	}

	public function update(Permission $permission)
	{
		$this->authorize('update', $permission);

		$this->validate(request(), [
			'name' => 'required',
			'key' => 'required'
		], [
			'name.required' => _m('authorize-permission-validation-name'),
			'key.required' => _m('authorize-permission-validation-key')
		]);

		updater(Permission::class)->data(request()->all())->update($permission);

		flash()->success(
			_m('authorize-permission-flash-updated-title'),
			_m('authorize-permission-flash-updated-message')
		);

		return redirect()->route('permissions.index');
	}

	public function destroy(Permission $permission)
	{
		$this->authorize('delete', $permission);

		$this->repo->delete($permission);

		flash()->success(
			_m('authorize-permission-flash-deleted-title'),
			_m('authorize-permission-flash-deleted-message')
		);

		return redirect()->route('permissions.index');
	}
}
