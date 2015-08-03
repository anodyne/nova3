<?php namespace Nova\Core\Access\Http\Controllers;

use Input,
	BaseController,
	RoleRepositoryInterface,
	PermissionRepositoryInterface,
	EditPermissionRequest, CreatePermissionRequest, RemovePermissionRequest;
use Nova\Core\Access\Events;
use Illuminate\Contracts\Foundation\Application;

class PermissionController extends BaseController {

	protected $repo;
	protected $roleRepo;

	public function __construct(Application $app, PermissionRepositoryInterface $repo,
			RoleRepositoryInterface $roles)
	{
		parent::__construct($app);

		$this->repo = $repo;
		$this->roleRepo = $roles;

		$this->middleware('auth');
	}

	public function index()
	{
		if ( ! $this->user->can(['access.create', 'access.edit', 'access.remove']))
		{
			return $this->errorUnauthorized("You do not have permission to manage access role permissions.");
		}

		$this->view = 'admin/access/role-permissions';
		$this->jsView = 'admin/access/role-permissions-js';
	}

	public function create()
	{
		if ( ! $this->user->can('access.create'))
		{
			return $this->errorUnauthorized("You do not have permission to create access role permissions.");
		}

		$this->view = 'admin/access/role-permission-create';
		$this->jsView = 'admin/access/role-permission-create-js';
	}

	public function store(CreatePermissionRequest $request)
	{
		if ( ! $this->user->can('access.create'))
		{
			return $this->errorUnauthorized("You do not have permission to create access role permissions.");
		}

		// Create the permission
		$permission = $this->repo->create($request->all());

		// Fire the event
		event(new Events\PermissionWasCreated($permission));

		// Set the flash message
		flash()->success("Access role permission has been created. You can now add this permission to any of your access roles.");

		return redirect()->route('admin.access.permissions');
	}

	public function edit($permissionId)
	{
		if ( ! $this->user->can('access.edit'))
		{
			return $this->errorUnauthorized("You do not have permission to edit access role permissions.");
		}

		$this->view = 'admin/access/role-permission-edit';
		$this->jsView = 'admin/access/role-permission-edit-js';

		$this->data->permission = $this->repo->find($permissionId);
	}

	public function update(EditPermissionRequest $request, $permissionId)
	{
		if ( ! $this->user->can('access.edit'))
		{
			return $this->errorUnauthorized("You do not have permission to edit access role permissions.");
		}

		// Update the permission
		$permission = $this->repo->update($permissionId, $request->all());

		// Fire the event
		event(new Events\PermissionWasUpdated($permission));

		// Set the flash message
		flash()->success("Access role permission has been updated.");

		return redirect()->route('admin.access.permissions');
	}

	public function remove($permissionId)
	{
		$this->isAjax = true;

		if ($this->user->can('access.remove'))
		{
			// Grab the permission we're removing
			$permission = $this->repo->find($permissionId);

			// Build the body based on whether we found the permission or not
			$body = ($permission)
				? view(locate('page', 'admin/access/role-permission-remove'), compact('permission'))
				: alert('danger', "Access role permission not found.");
		}
		else
		{
			$body = alert('danger', "You do not have permission to remove access role permissions.");
		}

		return partial('modal-content', [
			'header' => "Remove Permission",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemovePermissionRequest $request, $permissionId)
	{
		if ( ! $this->user->can('access.remove'))
		{
			return $this->errorUnauthorized("You do not have permission to remove access role permissions.");
		}

		// Delete the permission
		$permission = $this->repo->delete($permissionId);

		// Fire the event
		event(new Events\PermissionWasDeleted($permission->name, $permission->display_name));

		// Set the flash message
		flash()->success("Access role permission has been removed.");

		return redirect()->route('admin.access.permissions');
	}

	public function checkPermissionKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('name', Input::get('key'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

}
