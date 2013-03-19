<?php
/**
 * The model class is the foundation for all of Nova's models and provides core
 * functionality that's shared across a lot of the models used in Nova,
 * including creating a new items, updating an existing item, finding items
 * based on criteria, and deleting items.
 *
 * Because these methods are the basis for the majority of CRUD operations in 
 * Nova models, any changes to this class should be done carefully and 
 * deliberately since they can cause wide ranging issues if not done properly.
 *
 * @package		Nova
 * @subpackage	Foundation
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova\Foundation\Database\Eloquent;

use Status;
use Nova\Foundation\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {
	
	/**
	 * Override the default Eloquent Collection with our own.
	 *
	 * @param	array	An array of models
	 * @return	Collection
	 */
	public function newCollection(array $models = array())
	{
		return new Collection($models);
	}

	/**
	 * Kick off a new query.
	 *
	 * @return	Builder
	 */
	public static function startQuery()
	{
		// Get a new instance of the model
		$instance = new static;

		return $instance->newQuery();
	}

	/**
	 * Create an item with the data passed.
	 *
	 * @param	array	An array of data
	 * @param	bool	Should the object be returned?
	 * @param	bool	Should the data be filtered?
	 * @return	object|bool
	 */
	public static function add(array $data, $returnObject = false, $filter = true)
	{
		// Loop through the data and add it to the item
		foreach ($data as $key => $value)
		{
			if ($key != 'id' and in_array($key, static::$properties))
			{
				if ($filter)
				{
					$data[$key] = trim(\e($data[$key]));
				}
			}
		}

		// Create the item
		$item = static::create($data);
		
		if ($item !== null)
		{
			if ($returnObject)
			{
				return $item;
			}

			return true;
		}
		
		return false;
	}

	/**
	 * Create an item with the data passed.
	 *
	 * @param	array	An array of data
	 * @param	bool	Should the object be returned?
	 * @param	bool	Should the data be filtered?
	 * @return	mixed
	 */
	public static function createItem(array $data, $returnObject = false, $filter = true)
	{
		return static::add($data, $returnObject, $filter);
	}

	/**
	 * Find a record/records in the table based on the simple arguments.
	 *
	 * @param	string	The value
	 * @param	mixed	The column
	 * @param	bool	Is this for a search?
	 * @return	object
	 */
	public static function getItem($value, $column, $search = false)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		if (is_array($value))
		{
			// Loop through the arguments and build the where clause
			foreach ($value as $col => $val)
			{
				if (array_key_exists($col, static::$properties))
				{
					$query->where($col, $val);
				}
			}
			
			// Get the record
			return $query->first();
		}
		else
		{
			if (array_key_exists($column, static::$properties))
			{
				if ( ! $search)
				{
					return $query->where($column, $value)->first();
				}

				return $query->where($column, 'like', $value)->get();
			}
		}
		
		return false;
	}

	/**
	 * Find a form item based on the form key.
	 *
	 * @param	string	The form key
	 * @param	bool	Pull back displayed items (true) or all items (false)
	 * @return	object
	 */
	public static function getFormItems($key, $getOnlyActive = false)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		// Make sure we're pulling back the right form
		$query->where('form_key', $key);

		// Should we be getting all items or just enabled ones?
		if ($getOnlyActive)
		{
			$query->where('status', Status::ACTIVE);
		}

		// Order the items
		$query->orderBy('order', 'asc');

		return $query->get();
	}

	/**
	 * Update an item in the table based on the ID and data.
	 *
	 * @param	mixed	The ID to update or NULL to update everything
	 * @param	array 	The array of data to update with
	 * @param	bool	Should the data be run through the XSS filter?
	 * @return	mixed
	 */
	public static function update($id, array $data, $returnObject = false, $filter = true)
	{
		if ($id)
		{
			// Get the item
			$item = static::find($id);
			
			// Loop through the data array and make the changes
			foreach ($data as $key => $value)
			{
				if ($key != 'id' and array_key_exists($key, static::$properties))
				{
					if ($filter)
					{
						$value = \e($value);
					}

					$item->{$key} = $value;
				}
			}
			
			// Save the item
			if ($item->save())
			{
				if ($returnObject)
				{
					return $item;
				}

				return true;
			}

			return false;
		}
		else
		{
			// Start a new query
			$query = static::startQuery();

			// Pull everything from the table
			$items = $query->get();
			
			// Loop through all the items
			foreach ($items as $item)
			{
				// Loop through the data and make the changes
				foreach ($data as $key => $value)
				{
					if ($filter)
					{
						$value = \e($value);
					}

					$item->{$key} = $value;
				}
				
				// Save the item
				$item->save();
			}

			return true;
		}
	}
	
	/**
	 * Update an item in the table based on the ID and data.
	 *
	 * @param	mixed	The ID to update or NULL to update everything
	 * @param	array 	The array of data to update with
	 * @param	bool	Should the data be run through the XSS filter?
	 * @return	mixed
	 */
	public static function updateItem($id, array $data, $returnObject = false, $filter = true)
	{
		return static::update($id, $data, $returnObject, $filter);
	}

	/**
	 * Delete an item in the table based on the arguments passed.
	 *
	 * @param	mixed	An array of arguments or the item ID
	 * @return	bool
	 */
	public static function remove($args)
	{
		// If we have a list of arguments, loop through them
		if (is_array($args))
		{
			// Start a new query
			$query = static::startQuery();
			
			// Loop through the arguments to build the where
			foreach ($args as $column => $value)
			{
				if (array_key_exists($column, static::$properties))
				{
					$query->where($column, $value);
				}
			}

			// Get the item
			$entry = $query->first();
		}
		else
		{
			// Go directly to the item
			$entry = static::find($args);
		}

		// Now that we have the item, delete it
		if ($entry->delete(null, true))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * Delete an item in the table based on the arguments passed.
	 *
	 * @param	mixed	An array of arguments or the item ID
	 * @return	bool
	 */
	public static function deleteItem($args)
	{
		return static::remove($args);
	}

}