<?php namespace Nova\Authorize;

use Eloquent;

class Role extends Eloquent
{
	protected $table = 'roles';
	protected $fillable = ['name'];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'permissions_roles');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_roles');
	}

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public static function createWithPermissions(array $data)
	{
		// Create the role
		$role = static::create($data);

		if (array_key_exists('permissions', $data)) {
			// Sync the permissions
			$role->permissions()->sync($data['permissions']);
		}

		return $role;
	}

	public function scopeName($query, $roleName)
	{
		return $query->where('name', $roleName);
	}

	public function updatePermissions(array $data)
	{
		$this->permissions()->sync($data);

		return $this;
	}
}
