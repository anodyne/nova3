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

use Illuminate\Database\Eloquent\Model as lModel;

class Model extends lModel {
	
	/**
	 * Extended Eloquent Model
	 *
	 * These methods extend the default Eloquent behavior to
	 * add the observer functionality. This allows us to call classes
	 * at certain points during the execution of a model.
	 */
	public function delete()
	{
		$this->observe('beforeDelete');

		parent::delete();

		$this->observe('afterDelete');
	}

	public function save()
	{
		$this->observe('beforeSave');

		/**
		 * Begin parent::save()
		 */
		$keyName = $this->getKeyName();

		// First we need to create a fresh query instance and touch the creation and
		// update timestamp on the model which are maintained by us for developer
		// convenience. Then we will just continue saving the model instances.
		$query = $this->newQuery();

		if ($this->timestamps)
		{
			$this->updateTimestamps();
		}

		// If the model already exists in the database we can just update our record
		// that is already in this database using the current IDs in this "where"
		// clause to only update this model. Otherwise, we'll just insert them.
		if ($this->exists)
		{
			$this->observe('beforeUpdate');

			$query->where($keyName, '=', $this->getKey());

			$query->update($this->attributes);

			$this->observe('afterUpdate');
		}

		// If the model is brand new, we'll insert it into our database and set the
		// ID attribute on the model to the value of the newly inserted row's ID
		// which is typically an auto-increment value managed by the database.
		else
		{
			$this->observe('beforeInsert');

			if ($this->incrementing)
			{
				$this->$keyName = $query->insertGetId($this->attributes);
			}
			else
			{
				$query->insert($this->attributes);				
			}

			$this->observe('afterInsert');
		}

		$this->observe('afterSave');

		return $this->exists = true;

		/**
		 * End parent::save();
		 */
	}

	/**
	 * Observer Functionality
	 *
	 * This has been ported from FuelPHP 1.x to provide callback-like
	 * functionality on a per model basis. Credit due to the FuelPHP
	 * development team for this code.
	 */

	protected static $observersCached = array();

	public function observe($event)
	{
		return "Fired ${event}";

		foreach ($this->observers() as $observer => $settings)
		{
			// Get the events from the observer settings array
			$events = isset($settings['events']) ? $settings['events'] : array();
			
			if (empty($events) or in_array($event, $events))
			{
				if ( ! class_exists($observer))
				{
					// Add the observer with the full classname for next usage
					unset(static::$observersCached[$observer]);
					static::$observersCached[$observerClass] = $events;
					$observer = $observerClass;
				}

				try
				{
					call_user_func(array($observer, 'ormNotify'), $this, $event);
				}
				catch (\Exception $e)
				{
					throw $e;
				}
			}
		}
	}

	/**
	 * Get the class's observers and what they observe
	 *
	 * @param   string  specific observer to retrieve info of, allows direct param access by using dot notation
	 * @param   mixed   default return value when specific key wasn't found
	 * @return  array
	 */
	public static function observers($specific = null, $default = null)
	{
		$class = get_called_class();

		if ( ! array_key_exists($class, static::$observersCached))
		{
			$observers = array();
			
			if (property_exists($class, '_observers'))
			{
				foreach (static::$_observers as $obsK => $obsV)
				{
					if (is_int($obsK))
					{
						$observers[$obsV] = array();
					}
					else
					{
						$observers[$obsK] = $obsV;
					}
				}
			}
			static::$observersCached[$class] = $observers;
		}

		if ($specific)
		{
			return \Arr::get(static::$observersCached[$class], $specific, $default);
		}

		return static::$observersCached[$class];
	}

	/**
	 * Base Model
	 *
	 * These methods provide a consistent API across all of Nova's models.
	 */

	/**
	 * Create an item with the data passed.
	 *
	 * @api
	 * @param	mixed	An array or object of data
	 * @param	bool	Should the object be returned?
	 * @param	bool	Should the data be filtered?
	 * @return	mixed
	 */
	public static function createItem($data, $returnObject = false, $filter = true)
	{
		// Create a forge
		$item = static::forge();
		
		// Loop through the data and add it to the item
		foreach ($data as $key => $value)
		{
			if ($key != 'id' and array_key_exists($key, static::$properties))
			{
				if (is_array($data))
				{
					if ($filter)
					{
						$item->{$key} = \Security::xss_clean($data[$key]);
					}
					else
					{
						$item->{$key} = $data[$key];
					}
				}
				else
				{
					if ($filter)
					{
						$item->{$key} = \Security::xss_clean($data->{$key});
					}
					else
					{
						$item->{$key} = $data->{$key};
					}
				}
			}
		}
		
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
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

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
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		// Make sure we're pulling back the right form
		$query->where('form_key', $key);

		// Should we be getting all items or just enabled ones?
		if ($getOnlyActive)
		{
			$query->where('status', \Status::ACTIVE);
		}

		// Order the items
		$query->orderBy('order', 'asc');

		// Return the object
		return $query->get();
	}
	
	/**
	 * Update an item in the table based on the ID and data.
	 *
	 * @api
	 * @param	mixed	The ID to update or NULL to update everything
	 * @param	array 	The array of data to update with
	 * @param	bool	Should the data be run through the XSS filter?
	 * @return	mixed
	 */
	public static function updateItem($id, array $data, $returnObject = false, $filter = true)
	{
		if ($id !== null)
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
						$value = \Security::xss_clean($value);
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
			// Pull everything from the table
			$items = static::find('all');
			
			// Loop through all the items
			foreach ($items as $item)
			{
				// Loop through the data and make the changes
				foreach ($data as $key => $value)
				{
					if ($filter)
					{
						$value = \Security::xss_clean($value);
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
	 * Delete an item in the table based on the arguments passed.
	 *
	 * @api
	 * @param	mixed	An array of arguments or the item ID
	 * @return	bool
	 */
	public static function deleteItem($args)
	{
		// If we have a list of arguments, loop through them
		if (is_array($args))
		{
			// Start the find
			$item = static::query();

			// Loop through the arguments to build the where
			foreach ($args as $column => $value)
			{
				if (array_key_exists($column, static::$properties))
				{
					$item->where($column, $value);
				}
			}

			// Get the item
			$entry = $item->get_one();
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
}
