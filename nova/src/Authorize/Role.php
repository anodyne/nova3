<?php namespace Nova\Authorize;

use Eloquent;

class Role extends Eloquent
{
	protected $table = 'roles';
	protected $fillable = ['name'];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function perms()
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

	public function scopeName($query, $roleName)
	{
		return $query->where('name', $roleName);
	}
}
