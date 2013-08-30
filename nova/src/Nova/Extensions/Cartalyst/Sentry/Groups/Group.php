<?php namespace Nova\Extensions\Cartalyst\Sentry\Groups;

use Model;
use Cartalyst\Sentry\Groups\NameRequiredException;
use Cartalyst\Sentry\Groups\GroupExistsException;
use Cartalyst\Sentry\Groups\GroupInterface;

class Group extends Model implements GroupInterface {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'access_roles';

	/**
	 * Allowed permissions values.
	 *
	 * Possible options:
	 *    0 => Delete permissions
	 *    1 => Add permissions
	 *
	 * @var array
	 */
	protected $allowedPermissionsValues = array(0, 1);

	/**
	 * Returns the group's ID.
	 *
	 * @return mixed
	 */
	public function getId($id = false)
	{
		if ($id === false and isset($this->attributes[$keyName = $this->getKeyName()]))
		{
			$id = $this->attributes[$keyName];
		}

		return $id;
	}

	/**
	 * Returns the group's name.
	 *
	 * @return string
	 */
	public function getName($name = false)
	{
		if ($name === false and isset($this->attributes['name']))
		{
			$name = $this->attributes['name'];
		}

		return $name;
	}

	/**
	 * Returns permissions for the group.
	 *
	 * @return array
	 */
	public function getPermissions()
	{
		return $this->permissions;
	}

	/**
	 * Returns the relationship between groups and users.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany('Cartalyst\Sentry\Users\Eloquent\User', 'users_groups');
	}

	/**
	 * Saves the group.
	 *
	 * @return bool
	 */
	public function save()
	{
		$this->validate();
		return parent::save();
	}

	/**
	 * Delete the group.
	 *
	 * @return bool
	 */
	public function delete()
	{
		$this->users()->detach();
		return parent::delete();
	}

	/**
	 * Mutator for giving permissions.
	 *
	 * @param  mixed  $permissions
	 * @return array  $_permissions
	 */
	public function getPermissionsAttribute($permissions)
	{
		if ( ! $permissions)
		{
			return array();
		}

		if (is_array($permissions))
		{
			return $permissions;
		}

		if ( ! $_permissions = json_decode($permissions, true))
		{
			throw new \InvalidArgumentException("Cannot JSON decode permissions [$permissions].");
		}

		return $_permissions;
	}

	/**
	 * Mutator for taking permissions.
	 *
	 * @param  array  $permissions
	 * @return void
	 */
	public function setPermissionsAttribute(array $permissions)
	{
		// Merge permissions
		$permissions = array_merge($this->getPermissions(), $permissions);

		// Loop through and adjsut permissions as needed
		foreach ($permissions as $permission => &$value)
		{
			// Lets make sure their is a valid permission value
			if ( ! in_array($value = (int) $value, $this->allowedPermissionsValues))
			{
				throw new \InvalidArgumentException("Invalid value [$value] for permission [$permission] given.");
			}

			// If the value is 0, delete it
			if ($value === 0)
			{
				unset($permissions[$permission]);
			}
		}

		$this->attributes['permissions'] = ( ! empty($permissions)) ? json_encode($permissions) : '';
	}

	/**
	 * Convert the model instance to an array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		$attributes = parent::toArray();

		if (isset($attributes['permissions']))
		{
			$attributes['permissions'] = $this->getPermissionsAttribute($attributes['permissions']);
		}

		return $attributes;
	}

	/**
	 * Validates the group and throws a number of
	 * Exceptions if validation fails.
	 *
	 * @return bool
	 * @throws Cartalyst\Sentry\Groups\NameRequiredException
	 * @throws Cartalyst\Sentry\Groups\GroupExistsException
	 */
	public function validate()
	{
		// Check if name field was passed
		if ( ! $name = $this->name)
		{
			throw new NameRequiredException("A name is required for a group, none given.");
		}

		// Check if group already exists
		$query = $this->newQuery();
		$persistedGroup = $query->where('name', '=', $name)->first();

		if ($persistedGroup and $persistedGroup->getId() != $this->getId())
		{
			throw new GroupExistsException("A group already exists with name [$name], names must be unique for groups.");
		}

		return true;
	}

}
