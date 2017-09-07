<?php namespace Nova\Authorize;

use Eloquent;

class Permission extends Eloquent
{
	protected $fillable = ['name', 'key'];
	protected $table = 'permissions';

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------
	
	public function roles()
	{
		return $this->belongsToMany(Role::class, 'permissions_roles');
	}
}
