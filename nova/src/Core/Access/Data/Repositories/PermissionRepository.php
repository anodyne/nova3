<?php namespace Nova\Core\Access\Data\Repositories;

use Permission as Model,
	PermissionRepositoryInterface;
use Illuminate\Routing\Route;
use Nova\Foundation\Data\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function all()
	{
		return $this->model->with(['roles'])->get();
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function delete($id)
	{
		// Get the permission
		$permission = $this->find($id);

		if ($permission)
		{
			// Detach from any roles
			$permission->roles()->detach();

			// Delete the permission
			$permission->delete();

			return $permission;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['roles']);
	}

	public function update($id, array $data)
	{
		// Get the permission
		$permission = $this->find($id);

		if ($permission)
		{
			// Update the permission
			$permission->fill($data)->save();

			return $permission;
		}

		return false;
	}

}
