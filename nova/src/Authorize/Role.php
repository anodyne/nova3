<?php namespace Nova\Authorize;

use Eloquent;
use Laracasts\Presenter\PresentableTrait;

class Role extends Eloquent
{
	use PresentableTrait;

	protected $table = 'roles';
	protected $fillable = ['name'];
	protected $presenter = Presenters\RolePresenter::class;

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

	public static function create(array $attributes)
	{
		$role = (new static)->newQuery()->create($attributes);

		if (array_key_exists('permissions', $attributes)) {
			$role->permissions()->sync($attributes['permissions']);
		}

		return $role;
	}

	public function scopeName($query, $roleName)
	{
		return $query->where('name', $roleName);
	}

	public function delete()
	{
		$this->permissions()->sync([]);

		parent::delete();
	}

	public function update(array $attributes = [], array $options = [])
	{
		parent::update($attributes);

		if (array_key_exists('permissions', $attributes)) {
			$this->updatePermissions($attributes['permissions']);
		}

		return $this;
	}

	public function updatePermissions(array $data)
	{
		$this->permissions()->sync($data);

		return $this;
	}
}
