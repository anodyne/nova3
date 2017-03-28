<?php namespace Nova\Core\Access\Http\Controllers;

use Role;
use Permission;
use BaseController;
use RoleRepositoryContract;
use PermissionRepositoryContract;
use EditRoleRequest;
use CreateRoleRequest;
use RemoveRoleRequest;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
	protected $repo;
	protected $permissionsRepo;

	public function __construct(
		RoleRepositoryContract $repo,
		PermissionRepositoryContract $permissions
	) {
		parent::__construct();

		$this->isAdmin = true;

		$this->views->put('structure', 'admin');
		$this->views->put('template', 'admin');

		$this->repo = $repo;
		$this->permissionsRepo = $permissions;

		$this->middleware('auth');
	}

	public function all()
	{
		$role = $this->data->role = new Role;

		$this->authorize('manage', $role, "You do not have permission to manage roles.");

		$this->views->put('page', 'admin/access/roles');
		$this->views->put('scripts', ['admin/access/roles']);

		$this->data->roles = $this->repo->all();
		$this->data->permission = new Permission;
	}

	public function create()
	{
		$this->authorize('create', new Role, "You do not have permission to create roles.");

		$this->views->put('page', 'admin/access/role-create');
		$this->views->put('scripts', ['admin/access/role-create']);

		$this->data->permissions = $this->permissionsRepo->allByComponent();

		$this->data->keyCheckUrl = route('admin.access.roles.checkKey');
	}

	public function store(CreateRoleRequest $request)
	{
		$this->authorize('create', new Role, "You do not have permission to create roles.");

		$role = $this->repo->create($request->all());

		flash()->success("Role Created!");

		return redirect()->route('admin.access.roles');
	}

	public function edit($roleId)
	{
		$role = $this->data->role = $this->repo->find($roleId);

		$this->authorize('edit', $role, "You do not have permission to edit roles.");

		$this->views->put('page', 'admin/access/role-edit');
		$this->views->put('scripts', ['admin/access/role-edit']);

		$this->data->permissions = $this->permissionsRepo->allByComponent();

		$this->data->keyCheckUrl = route('admin.access.roles.checkKey');
	}

	public function update(EditRoleRequest $request, $roleId)
	{
		$this->authorize('edit', new Role, "You do not have permission to edit roles.");

		$role = $this->repo->update($roleId, $request->all());

		flash()->success("Role Updated!");

		return redirect()->route('admin.access.roles');
	}

	public function remove($roleId)
	{
		$this->isAjax = true;

		$role = $this->repo->find($roleId);

		if (policy($role)->remove($this->user)) {
			$body = ($role)
				? view(locate('page', 'admin/access/role-remove'), compact('role'))
				: alert('danger', "Role not found.");
		} else {
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

		flash()->success("Role Removed!");

		return redirect()->route('admin.access.roles');
	}

	public function checkRoleKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('key', request('key'));

		if ($count > 0) {
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

	public function duplicate($roleId)
	{
		$this->isAjax = true;

		$role = $this->repo->find($roleId);

		if (policy($role)->create($this->user)) {
			$body = ($role)
				? view(locate('page', 'admin/access/role-duplicate'), compact('role'))
				: alert('danger', "Role not found.");
		} else {
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
			$request->input('name'),
			$request->input('key')
		);

		flash()->success("Role Duplicated!");

		return redirect()->route('admin.access.roles');
	}

	public function usersWithRole($roleId)
	{
		$this->isAjax = true;

		$role = $this->repo->getById($roleId, ['users']);

		if (! $role) {
			$body = alert('danger', "Role could not be found");
		} else {
			$body = view(locate()->page('admin/access/role-users'), compact('role'));
		}

		return partial('modal-content', [
			'header' => "Users With Role",
			'body' => $body,
			'footer' => false,
		]);
	}
}
