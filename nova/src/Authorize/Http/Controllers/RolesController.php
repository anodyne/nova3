<?php

namespace Nova\Authorize\Http\Controllers;

use Controller;
use Nova\Authorize\Role;
use Illuminate\Http\Response;
use Nova\Authorize\Permission;
use Nova\Authorize\Jobs\CreateRoleJob;
use Nova\Authorize\Jobs\DeleteRoleJob;
use Nova\Authorize\Jobs\UpdateRoleJob;
use Nova\Authorize\Http\Requests\CreateRoleRequest;
use Nova\Authorize\Http\Requests\UpdateRoleRequest;
use Nova\Authorize\Http\Responses\RoleIndexResponse;

class RolesController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'template');
	}

	public function index()
	{
		$this->authorize('manage', Role::class);

		$this->setPageTitle(_m('authorize-roles'));

		return app(RoleIndexResponse::class)->with([
			'roles' => cache('nova.roles'),
			'roleClass' => Role::class,
			'permissionClass' => Permission::class,
		]);
	}

	public function create()
	{
		$this->authorize('create', Role::class);

		$this->views('authorize.create-role', 'page|script');

		$this->setPageTitle(_m('authorize-roles-add'));

		$this->data->permissions = cache('nova.permissions');
		$this->data->oldPermissions = old('permissions');
	}

	public function store(CreateRoleRequest $request)
	{
		$this->authorize('create', Role::class);

		$this->dispatch(new CreateRoleJob($request->validated()));

		flash()
			->title(_m('authorize-roles-flash-added-title'))
			->message(_m('authorize-roles-flash-added-message'))
			->success();

		return redirect()->route('roles.index');
	}

	public function edit(Role $role)
	{
		$this->authorize('update', $role);

		$this->views('authorize.edit-role', 'page|script');

		$this->setPageTitle(_m('authorize-roles-update'));

		$this->data->role = $role->loadMissing('permissions');
		$this->data->permissions = cache('nova.permissions');
		$this->data->oldPermissions = old('permissions');
	}

	public function update(UpdateRoleRequest $request, Role $role)
	{
		$this->authorize('update', $role);

		$this->dispatch(new UpdateRoleJob($request->validated(), $role));

		flash()
			->title(_m('authorize-roles-flash-updated-title'))
			->message(_m('authorize-roles-flash-updated-message'))
			->success();

		return redirect()->route('roles.index');
	}

	public function destroy(Role $role)
	{
		$this->authorize('delete', $role);

		$this->dispatch(new DeleteRoleJob([], $role));

		return response()->json($role, Response::HTTP_NO_CONTENT);
	}
}
