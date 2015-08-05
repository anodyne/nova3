<?php namespace Nova\Core\Access\Data\Repositories;

use Role as Model,
	RoleRepositoryInterface;
use Illuminate\Routing\Route;
use Nova\Foundation\Data\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function all()
	{
		return $this->model->with(['perms', 'users'])->get();
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function delete($id)
	{
		// Get the role we're removing
		$role = $this->find($id);

		if ($role)
		{
			// Detach the permissions
			$role->perms()->detach();

			// Detach any users with this role
			$role->users()->detach();

			// Delete the role
			$role->delete();

			return $role;
		}

		return false;
	}

	public function duplicate($id)
	{
		// Get the item we're duplicate from
		$original = $this->find($id);

		if ($original)
		{
			// Replicate the original object
			$new = $original->replicate();

			// Push the duplicated object so we have an ID
			$new->push();

			// Update the attributes
			$new->display_name = "Copy of ".$new->display_name;
			$new->name = $new->name."-copy";
			$new->save();

			// Duplicate the permissions for the role
			$new->attachPermissions($original->perms);

			return $new;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['perms']);
	}

	public function update($id, array $data)
	{
		// Get the role we're updating
		$role = $this->find($id);

		if ($role)
		{
			// Fill and save the role
			$role->fill($data)->save();

			return $role;
		}

		return false;
	}

}
