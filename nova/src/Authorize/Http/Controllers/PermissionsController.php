<?php

namespace Nova\Authorize\Http\Controllers;

use Controller;
use Nova\Authorize\Role;
use Nova\Authorize\Permission;
use Nova\Authorize\Jobs\CreatePermissionJob;
use Nova\Authorize\Jobs\DeletePermissionJob;
use Nova\Authorize\Jobs\UpdatePermissionJob;
use Nova\Authorize\Http\Requests\CreatePermissionRequest;
use Nova\Authorize\Http\Requests\UpdatePermissionRequest;

class PermissionsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'template');
	}

	public function index()
	{
		$permissionClass = new Permission;

		$this->authorize('manage', $permissionClass);

		$this->views('authorize.all-permissions', 'page|script');

		$this->setPageTitle(_m('authorize-permissions'));

		$this->data->permissions = cache('nova.permissions');
		$this->data->roleClass = new Role;
		$this->data->permissionClass = $permissionClass;
	}

	public function create()
	{
		$this->authorize('create', new Permission);

		$this->views('authorize.create-permission');

		$this->setPageTitle(_m('authorize-permissions-add'));
	}

	public function store(CreatePermissionRequest $request)
	{
		$this->renderWithTheme = false;

		$this->dispatch(new CreatePermissionJob($request->validated()));

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

		$this->setPageTitle(_m('authorize-permissions-update'));

		$this->data->permission = $permission;
	}

	public function update(UpdatePermissionRequest $request, Permission $permission)
	{
		$this->renderWithTheme = false;

		$this->dispatch(new UpdatePermissionJob($request->validated(), $permission));

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

		$this->dispatch(new DeletePermissionJob([], $permission));

		return response()->json($permission, Response::HTTP_NO_CONTENT);
	}
}
