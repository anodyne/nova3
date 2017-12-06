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

		$this->views('admin', 'structure|template');
	}

	public function index()
	{
		$permissionClass = new Permission;

		$this->authorize('manage', $permissionClass);

		$this->views('authorize.all-permissions', 'page|script');

		$this->pageTitle = _m('authorize-permissions');

		$this->data->permissions = cache('nova.permissions');
		$this->data->roleClass = new Role;
		$this->data->permissionClass = $permissionClass;
	}

	public function create()
	{
		$this->authorize('create', new Permission);

		$this->views('authorize.create-permission');

		$this->pageTitle = _m('authorize-permissions-add');
	}

	public function store()
	{
		$this->renderWithTheme = false;

		$this->authorize('create', new Permission);

		$this->validate(request(), [
			'name' => 'required',
			'key' => 'required'
		], [
			'name.required' => _m('validation-name-required'),
			'key.required' => _m('validation-key-required')
		]);

		creator(Permission::class)->with(request()->all())->create();

		flash()
			->title(_m('authorize-permissions-flash-added-title'))
			->message(_m('authorize-permissions-flash-added-message'))
			->success();

		return redirect()->route('permissions.index');
	}

	public function edit(Permission $permission)
	{
		$this->authorize('update', $permission);

		$this->views('authorize.edit-permission');

		$this->pageTitle = _m('authorize-permissions-update');

		$this->data->permission = $permission;
	}

	public function update(Permission $permission)
	{
		$this->renderWithTheme = false;

		$this->authorize('update', $permission);

		$this->validate(request(), [
			'name' => 'required',
			'key' => 'required'
		], [
			'name.required' => _m('validation-name-required'),
			'key.required' => _m('validation-key-required')
		]);

		updater(Permission::class)->with(request()->all())->update($permission);

		flash()
			->title(_m('authorize-permissions-flash-updated-title'))
			->message(_m('authorize-permissions-flash-updated-message'))
			->success();

		return redirect()->route('permissions.index');
	}

	public function destroy(Permission $permission)
	{
		$this->renderWithTheme = false;

		$this->authorize('delete', $permission);

		deletor(Permission::class)->delete($permission);

		return response($permission, 200);
	}
}
