<?php namespace Nova\Core\Access\Data;

use User,
	Model,
	RolePresenter,
	Permission as PermissionModel;
use Illuminate\Support\Collection;
use Laracasts\Presenter\PresentableTrait;

class Role extends Model {

	use PresentableTrait;

	protected $table = 'roles';

	protected $fillable = ['key', 'name', 'description'];

	protected $hidden = ['created_at', 'updated_at', 'pivot'];

	protected $presenter = RolePresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function permissions()
	{
		return $this->belongsToMany(PermissionModel::class, 'roles_permissions');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_roles');
	}

	//-------------------------------------------------------------------------
	// Model Methods
	//-------------------------------------------------------------------------

	public function addPermissions($permissions)
	{
		if ($permissions instanceof Collection)
		{
			$newPermissions = [];

			foreach ($permissions as $permission)
			{
				$newPermissions[] = $permission->id;
			}

			$permissions = $newPermissions;
		}

		if (is_array($permissions))
		{
			// Sync all the permissions
			$this->permissions()->sync($permissions);

			return true;
		}

		// Attach the single permission
		$this->permissions()->attach($permissions);

		return true;
	}

	public function removePermissions($permissions)
	{
		//
	}

}
