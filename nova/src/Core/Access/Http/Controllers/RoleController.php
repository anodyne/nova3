<?php namespace Nova\Core\Access\Http\Controllers;

use Input,
	BaseController,
	RoleRepositoryInterface,
	PermissionRepositoryInterface,
	EditRoleRequest, CreateRoleRequest, RemoveRoleRequest;
use Nova\Core\Access\Events;
use Illuminate\Contracts\Foundation\Application;

class RoleController extends BaseController {

	protected $repo;
	protected $permissionsRepo;

	public function __construct(Application $app, RoleRepositoryInterface $repo,
			PermissionRepositoryInterface $permissions)
	{
		parent::__construct($app);

		$this->repo = $repo;
		$this->permissionsRepo = $permissions;

		$this->middleware('auth');
	}

	public function index()
	{
		if ( ! $this->user->can(['access.create', 'access.edit', 'access.remove']))
		{
			return $this->errorUnauthorized("You do not have permission to manage access roles.");
		}

		$this->view = 'admin/access/roles';
		$this->jsView = 'admin/access/roles-js';

		$this->data->roles = $this->repo->all();
	}

	public function create()
	{
		if ( ! $this->user->can('access.create'))
		{
			return $this->errorUnauthorized("You do not have permission to create access roles.");
		}

		$this->view = 'admin/access/role-create';
		$this->jsView = 'admin/access/role-create-js';
	}

	public function store(CreateRoleRequest $request)
	{
		if ( ! $this->user->can('access.create'))
		{
			return $this->errorUnauthorized("You do not have permission to create access roles.");
		}

		// Create the role
		$role = $this->repo->create($request->all());

		// Fire the event
		event(new Events\RoleWasCreated($role));

		// Set the flash message
		flash()->success("Role Created!");

		return redirect()->route('admin.access.roles');
	}

	public function edit($roleId)
	{
		if ( ! $this->user->can('access.edit'))
		{
			return $this->errorUnauthorized("You do not have permission to edit access roles.");
		}

		$this->view = 'admin/access/role-edit';
		$this->jsView = 'admin/access/role-edit-js';

		$this->data->role = $this->repo->find($roleId);
	}

	public function update(EditRoleRequest $request, $roleId)
	{
		if ( ! $this->user->can('access.edit'))
		{
			return $this->errorUnauthorized("You do not have permission to edit access roles.");
		}

		// Update the role
		$role = $this->repo->update($roleId, $request->all());

		// Fire the event
		event(new Events\RoleWasUpdated($role));

		// Set the flash message
		flash()->success("Role Updated!");

		return redirect()->route('admin.access.roles');
	}

	public function remove($roleId)
	{
		$this->isAjax = true;

		if ($this->user->can('access.remove'))
		{
			// Grab the role we're removing
			$role = $this->repo->find($roleId);

			// Build the body based on whether we found the role or not
			$body = ($role)
				? view(locate('page', 'admin/access/role-remove'), compact('role'))
				: alert('danger', "Access role not found.");
		}
		else
		{
			$body = alert('danger', "You do not have permission to remove access roles.");
		}

		return partial('modal-content', [
			'header' => "Remove Access Role",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveRoleRequest $request, $roleId)
	{
		if ( ! $this->user->can('access.remove'))
		{
			return $this->errorUnauthorized("You do not have permission to remove access roles.");
		}

		// Delete the role
		$role = $this->repo->delete($roleId);

		// Fire the event
		event(new Events\RoleWasDeleted($role->name));

		// Set the flash message
		flash()->success("Role Removed!");

		return redirect()->route('admin.access.roles');
	}

	public function checkRoleKey()
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
