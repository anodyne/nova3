<?php namespace Nova\Authorize\Http\Controllers;

use Controller;
use Nova\Authorize\Role;
use Nova\Authorize\Permission;

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

		creator(Permission::class)->with(request()->all())->create();

		flash()
			->title(_m('authorize-permission-flash-added-title'))
			->message(_m('authorize-permission-flash-added-message'))
			->success();

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

		updater(Permission::class)->with(request()->all())->update($permission);

		flash()
			->title(_m('authorize-permission-flash-updated-title'))
			->message(_m('authorize-permission-flash-updated-message'))
			->success();

		return redirect()->route('permissions.index');
	}

	public function destroy(Permission $permission)
	{
		$this->authorize('delete', $permission);

		deletor(Permission::class)->delete($permission);

		flash()
			->title(_m('authorize-permission-flash-deleted-title'))
			->message(_m('authorize-permission-flash-deleted-message'))
			->success();

		return redirect()->route('permissions.index');
	}
}
