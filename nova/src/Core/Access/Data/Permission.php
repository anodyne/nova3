<?php namespace Nova\Core\Access\Data;

use Model;
use Role as RoleModel;
use PermissionPresenter;
use Laracasts\Presenter\PresentableTrait;

class Permission extends Model
{
	use PresentableTrait;

	protected $table = 'permissions';

	protected $fillable = ['key', 'name', 'description'];

	protected $hidden = ['created_at', 'updated_at', 'pivot'];

	protected $appends = ['createUrl', 'deleteUrl', 'editUrl'];

	protected $casts = [
		'protected'	=> 'boolean',
	];

	protected $presenter = PermissionPresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function roles()
	{
		return $this->belongsToMany(RoleModel::class, 'roles_permissions');
	}

	//-------------------------------------------------------------------------
	// Accessors
	//-------------------------------------------------------------------------

	public function getCreateUrlAttribute()
	{
		return route('admin.access.permissions.create');
	}

	public function getDeleteUrlAttribute()
	{
		return route('admin.access.permissions.remove', [$this->id]);
	}

	public function getEditUrlAttribute()
	{
		return route('admin.access.permissions.edit', [$this->id]);
	}
}
