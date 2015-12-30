<?php namespace Nova\Core\Access\Http\Controllers;

use Role,
	Permission,
	BaseController,
	RoleRepositoryInterface,
	PermissionRepositoryInterface,
	EditRoleRequest, CreateRoleRequest, RemoveRoleRequest;
use Nova\Core\Access\Events;
use Illuminate\Http\Request;

class RoleController extends BaseController {

	protected $repo;
	protected $permissionsRepo;

	public function __construct(RoleRepositoryInterface $repo,
			PermissionRepositoryInterface $permissions)
	{
		parent::__construct();

		$this->structureView = 'admin';
		$this->templateView = 'admin';

		$this->repo = $repo;
		$this->permissionsRepo = $permissions;

		$this->middleware('auth');
	}

	public function index()
	{
		$role = $this->data->role = new Role;

		$this->authorize('manage', $role, "You do not have permission to manage roles.");

		$this->view = 'admin/access/roles';
		$this->jsView = 'admin/access/roles-js';

		$this->data->roles = $this->repo->all();
		$this->data->permission = new Permission;
	}

	public function create()
	{
		$this->authorize('create', new Role, "You do not have permission to create roles.");

		$this->view = 'admin/access/role-create';
		$this->jsView = 'admin/access/role-create-js';

		$this->data->permissions = $this->permissionsRepo->allByComponent();
	}

	public function store(CreateRoleRequest $request)
	{
		$this->authorize('create', new Role, "You do not have permission to create roles.");

		$role = $this->repo->create($request->all());

		event(new Events\RoleWasCreated($role));

		flash()->success("Role Created!");

		return redirect()->route('admin.access.roles');
	}

	public function edit($roleId)
	{
		$role = $this->data->role = $this->repo->find($roleId);

		$this->authorize('edit', $role, "You do not have permission to edit roles.");

		$this->view = 'admin/access/role-edit';
		$this->jsView = 'admin/access/role-edit-js';

		$this->data->permissions = $this->permissionsRepo->allByComponent();
	}

	public function update(EditRoleRequest $request, $roleId)
	{
		$role = $this->repo->find($roleId);

		$this->authorize('edit', $role, "You do not have permission to edit roles.");

		$role = $this->repo->update($role, $request->all());

		event(new Events\RoleWasUpdated($role));

		flash()->success("Role Updated!");

		return redirect()->route('admin.access.roles');
	}

	public function remove($roleId)
	{
		$this->isAjax = true;

		$role = $this->repo->find($roleId);

		if (policy($role)->remove($this->user))
		{
			$body = ($role)
				? view(locate('page', 'admin/access/role-remove'), compact('role'))
				: alert('danger', "Role not found.");
		}
		else
		{
			$body = alert('danger', "You do not have permission to remove roles.");
		}

		return partial('modal-content', [
			'header' => "Remove Role",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveRoleRequest $request, $roleId)
	{
		$this->authorize('remove', new Role, "You do not have permission to remove roles.");

		$role = $this->repo->delete($roleId);

		event(new Events\RoleWasDeleted($role->name));

		flash()->success("Role Removed!");

		return redirect()->route('admin.access.roles');
	}

	public function checkRoleKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('name', request('key'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

	public function duplicate($roleId)
	{
		$this->isAjax = true;

		$role = $this->repo->find($roleId);

		if (policy($role)->create($this->user))
		{
			$body = ($role)
				? view(locate('page', 'admin/access/role-duplicate'), compact('role'))
				: alert('danger', "Role not found.");
		}
		else
		{
			$body = alert('danger', "You do not have permission to create roles.");
		}

		return partial('modal-content', [
			'header' => "Duplicate Role",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function copy(Request $request, $roleId)
	{
		$oldRole = $this->repo->find($roleId);

		$this->authorize('create', $oldRole, "You do not have permission to create roles.");

		$newRole = $this->repo->duplicate(
			$oldRole,
			$request->input('display_name'),
			$request->input('name')
		);

		event(new Events\RoleWasDuplicated($oldRole, $newRole));

		flash()->success("Role Duplicated!");

		return redirect()->route('admin.access.roles');
	}

}
