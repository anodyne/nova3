<?php namespace Nova\Core\Access\Data;

use Model,
	RolePresenter,
	Permission as PermissionModel;
use Laracasts\Presenter\PresentableTrait;

class Role extends Model {

	use PresentableTrait;

	protected $table = 'roles';

	protected $fillable = ['name', 'display_name', 'description'];

	protected $presenter = RolePresenter::class;

	public function permissions()
	{
		return $this->belongsToMany(PermissionModel::class, 'roles_permissions');
	}

}
