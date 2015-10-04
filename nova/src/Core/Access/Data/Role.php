<?php namespace Nova\Core\Access\Data;

use User,
	Model,
	RolePresenter,
	Permission as PermissionModel;
use Laracasts\Presenter\PresentableTrait;

class Role extends Model {

	use PresentableTrait;

	protected $table = 'roles';

	protected $fillable = ['name', 'display_name', 'description'];

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

}
