<?php
/**
 * Part of the Sentry package for Nova.
 *
 * @package		Nova
 * @subpackage	Sentry
 * @category	Class
 * @author		Cartalyst LLC
 * @author		Anodyne Productions
 * @license		MIT License
 * @copyright	2011 Cartalyst LLC
 */

namespace Nova\Sentry;

use Lang;
use AccessRoleModel;

class SentryGroupException extends \Exception {}
class SentryGroupNotFoundException extends SentryGroupException {}

class Group implements \Iterator, \ArrayAccess {

	/**
	 * @var  array  Group array
	 */
	protected $group = array();

	/**
	 * Gets all the group info.
	 *
	 * @param   string|int  Group id or name
	 * @return  void
	 */
	public function __construct($id = null)
	{
		if ($id === null)
		{
			return;
		}

		if (is_numeric($id))
		{
			if ($id <= 0)
			{
				throw new SentryGroupException(Lang::get('sentry.invalid_group_id'));
			}

			$field = 'id';
		}
		else
		{
			$field = 'name';
		}
		
		$group = AccessRoleModel::getItem($id, $field);

		// If there was a result - update user
		if (count($group))
		{
			$this->group = $group;
		}
		else
		{
			throw new SentryGroupNotFoundException(Lang::get('sentry.group_not_found', array('group' => $id)));
		}
	}

	/**
	 * Creates the given group.
	 *
	 * @param   array  Group info
	 * @return  int|bool
	 */
	public function create($group)
	{
		# TODO: you should be able to create a group, but it should use the model instead

		throw new \Exception('Sentry\\Group::create is under development');
	}

	/**
	 * Update the given group
	 *
	 * @param   array  fields to be updated
	 * @return  bool
	 * @throws  SentryGroupException
	 */
	public function update(array $fields)
	{
		# TODO: you should be able to update a group, but it should use the model instead

		throw new \Exception('Sentry\\Group::update is under development');
	}

	/**
	 * Delete's the current group.
	 *
	 * @return  bool
	 * @throws  SentryGroupException
	 */
	public function delete()
	{
		# TODO: you should be able to delete a group, but it should use the model instead

		throw new \Exception('Sentry\\Group::delete is under development');
	}

	/**
	 * Checks if the Field is set or not.
	 *
	 * @param   string  Field name
	 * @return  bool
	 */
	public function __isset($field)
	{
		return array_key_exists($field, $this->group);
	}

	/**
	 * Gets a field value of the group
	 *
	 * @param   string  Field name
	 * @return  mixed
	 * @throws  SentryGroupException
	 */
	public function __get($field)
	{
		return $this->get($field);
	}

	/**
	 * Gets a given field (or array of fields).
	 *
	 * @param   string|array  Field(s) to get
	 * @return  mixed
	 * @throws  SentryGroupException
	 */
	public function get($field = null)
	{
		// make sure a group id is set
		if (empty($this->group['id']))
		{
			throw new SentryGroupException(Lang::get('sentry.no_group_selected'));
		}

		// if no fields were passed - return entire user
		if ($field === null)
		{
			return $this->group;
		}
		// if field is an array - return requested fields
		else if (is_array($field))
		{
			$values = array();

			// loop through requested fields
			foreach ($field as $key)
			{
				// check to see if field exists in group
				if (array_key_exists($key, $this->group))
				{
					$values[$key] = $this->group[$key];
				}
				else
				{
					throw new SentryGroupException(
						Lang::get('sentry.not_found_in_group_object', array('field' => $key))
					);
				}
			}

			return $values;
		}
		else
		{
			// check to see if field exists in group
			if (array_key_exists($field, $this->group))
			{
				return $this->group[$field];
			}

			throw new SentryGroupException(
				Lang::get('sentry.not_found_in_group_object', array('field' => $field))
			);
		}
	}

	/**
	 * Gets all the users for this group.
	 *
	 * @return  array
	 */
	public function users()
	{
		$users = AccessRoleModel::find($this->group['id'])->users;
		
		if (count($users) == 0)
		{
			return array();
		}
		
		return $users;
	}

	/**
	 * Retruns all groups
	 *
	 * @return  array
	 */
	public function all()
	{
		return AccessRoleModel::all();
	}

	/**
	 * Implementation of the Iterator interface
	 */

	protected $_iterable = array();

	public function rewind()
	{
		$this->_iterable = $this->group;
		reset($this->_iterable);
	}

	public function current()
	{
		return current($this->_iterable);
	}

	public function key()
	{
		return key($this->_iterable);
	}

	public function next()
	{
		return next($this->_iterable);
	}

	public function valid()
	{
		return key($this->_iterable) !== null;
	}

	/**
	 * Sets the value of the given offset (class property).
	 *
	 * @param   string  $offset  class property
	 * @param   string  $value   value
	 * @return  void
	 */
	public function offsetSet($offset, $value)
	{
		$this->{$offset} = $value;
	}

	/**
	 * Checks if the given offset (class property) exists.
	 *
	 * @param   string  $offset  class property
	 * @return  bool
	 */
	public function offsetExists($offset)
	{
		return isset($this->{$offset});
	}

	/**
	 * Unsets the given offset (class property).
	 *
	 * @param   string  $offset  class property
	 * @return  void
	 */
	public function offsetUnset($offset)
	{
		unset($this->{$offset});
	}

	/**
	 * Gets the value of the given offset (class property).
	 *
	 * @param   string  $offset  class property
	 * @return  mixed
	 */
	public function offsetGet($offset)
	{
		if (isset($this->{$offset}))
		{
			return $this->{$offset};
		}

		throw new \OutOfBoundsException('Property "'.$offset.'" not found for '.get_called_class().'.');
	}
}
