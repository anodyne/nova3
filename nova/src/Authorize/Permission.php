<?php namespace Nova\Authorize;

use Eloquent;

class Permission extends Eloquent
{
	protected $table = 'permissions';
	protected $fillable = ['name', 'key'];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------
	
	public function roles()
	{
		return $this->belongsToMany(Role::class, 'permissions_roles');
	}

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function delete()
	{
		$this->roles()->sync([]);

		parent::delete();
	}
}
