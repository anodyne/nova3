<?php namespace Nova\Foundation\Database\Eloquent;

/**
 * The model class is the foundation for all of Nova's models and provides core
 * functionality that's shared across a lot of the models used in Nova,
 * including creating a new items, updating an existing item, finding items
 * based on criteria, and deleting items.
 *
 * Because these methods are the basis for the majority of CRUD operations in 
 * Nova models, any changes to this class should be done carefully and 
 * deliberately since they can cause wide ranging issues if not done properly.
 */

use Date;
use Status;
use Exception;
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
	 * Get a fresh timestamp for the model.
	 *
	 * @return mixed
	 */
	public function freshTimestamp()
	{
		return Date::now('UTC')->toDateTimeString();
	}

	/**
	 * Delete the model from the database.
	 *
	 * @return void
	 */
	public function delete()
	{
		if ($this->exists)
		{
			// Fire the "deleting" event
			if ($this->fireModelEvent('deleting') === false) return false;

			// Do the delete
			$retval = parent::delete();

			// Fire the "deleted" event
			$this->fireModelEvent('deleted', false);
			
			return $retval;
		}
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
	 * @return	$this|bool
	 * @throws	Exception
	 */
	public static function add(array $data, $returnObject = false, $filter = true)
	{
		// Loop through the data and add it to the item
		foreach ($data as $key => $value)
		{
			// Make sure we don't have an ID field or something that
			// isn't actually a column in the database
			if ($key != 'id' and in_array($key, static::$properties))
			{
				if ($filter)
				{
					$data[$key] = trim(e($data[$key]));
				}
			}
			else
			{
				unset($data[$key]);
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
		
		throw new Exception(lang('error.exception.model.create'));
	}

	/**
	 * Find a record/records in the table based on the simple arguments.
	 *
	 * @param	string	The value
	 * @param	mixed	The column
	 * @return	object
	 */
	public static function getItem($value, $column)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		if (is_array($value))
		{
			// Loop through the arguments and build the where clause
			foreach ($value as $col => $val)
			{
				if (in_array($col, static::$properties))
				{
					$query->where($col, $val);
				}
			}
			
			// Get the record
			return $query->first();
		}
		else
		{
			if (in_array($column, static::$properties))
			{
				return $query->where($column, $value)->first();
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
	 * @throws	Exception
	 */
	public static function update($id, array $data, $returnObject = false, $filter = true)
	{
		if ($id)
		{
			// Get the item
			$item = static::find($id);
			
			// Make sure we have something
			if ($item !== null)
			{
				// Loop through the data array and make the changes
				foreach ($data as $key => $value)
				{
					if ($key != 'id' and in_array($key, static::$properties))
					{
						if ($filter)
						{
							$value = e($value);
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

				throw new Exception(lang('error.exception.model.update.notSaved'));
			}
		}
		else
		{
			// Start a new query
			$query = static::startQuery();

			// Pull everything from the table
			$items = $query->get();

			// Make sure we have items
			if ($items->count() > 0)
			{
				// Loop through all the items
				foreach ($items as $item)
				{
					// Loop through the data and make the changes
					foreach ($data as $key => $value)
					{
						if ($filter)
						{
							$value = e($value);
						}

						$item->{$key} = $value;
					}
					
					// Save the item
					$item->save();
				}

				return true;
			}
		}

		throw new Exception(lang('error.exception.model.update.notFound'));
	}

	/**
	 * Delete an item in the table based on the arguments passed.
	 *
	 * @param	mixed	An array of arguments or the item ID
	 * @return	bool
	 * @throws	Exception
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
				if (in_array($column, static::$properties))
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

		// Make sure we have an entry
		if ($entry !== null)
		{
			// Now that we have the item, delete it
			if ($entry->delete(null, true))
			{
				return true;
			}
		}
		
		throw new Exception(lang('error.exception.model.delete'));
	}

}