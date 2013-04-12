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
use Config;
use Status;
use Exception;
use Nova\Foundation\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {
	
	/*
	|--------------------------------------------------------------------------
	| Eloquent Model Method Overrides
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new Eloquent Collection instance.
	 *
	 * We override this method from the Eloquent model so that we
	 * can ensure every collection being created is one of our own
	 * making and not the default.
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
	 * We override this method from the Eloquent model so that we
	 * can ensure that every timestamp being generated is done so
	 * as UTC.
	 *
	 * @return mixed
	 */
	public function freshTimestamp()
	{
		return Date::now('UTC');
	}

	/**
	 * Return a timestamp as DateTime object.
	 *
	 * We override this method from the Eloquent model so that we
	 * can ensure that everything being stored in the database is
	 * being done so as UTC.
	 *
	 * @param	mixed	The value to store
	 * @return	Date
	 */
	protected function asDateTime($value)
	{
		if ( ! $value instanceof Date)
		{
			$format = $this->getDateFormat();

			return Date::createFromFormat($format, $value, 'UTC');
		}

		return $value;
	}

	/**
	 * Define a one-to-one relationship.
	 *
	 * We override this method from the Eloquent model so that we
	 * can grab the class alias from the config file and create
	 * the model based on what class SHOULD be used instead of
	 * assuming the core should be used.
	 *
	 * @param  string  $related
	 * @param  string  $foreignKey
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function hasOne($related, $foreignKey = null)
	{
		// Get the class aliases
		$aliases = Config::get('app.aliases');

		// Figure out what the real model class should be
		$model = $aliases[$related];

		return parent::hasOne($model, $foreignKey);
	}

	/**
	 * Define an inverse one-to-one or many relationship.
	 *
	 * We override this method from the Eloquent model so that we
	 * can grab the class alias from the config file and create
	 * the model based on what class SHOULD be used instead of
	 * assuming the core should be used.
	 *
	 * @param  string  $related
	 * @param  string  $foreignKey
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function belongsTo($related, $foreignKey = null)
	{
		// Get the class aliases
		$aliases = Config::get('app.aliases');

		// Figure out what the real model class should be
		$model = $aliases[$related];

		return parent::belongsTo($model, $foreignKey);
	}

	/**
	 * Define a one-to-many relationship.
	 *
	 * We override this method from the Eloquent model so that we
	 * can grab the class alias from the config file and create
	 * the model based on what class SHOULD be used instead of
	 * assuming the core should be used.
	 *
	 * @param  string  $related
	 * @param  string  $foreignKey
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function hasMany($related, $foreignKey = null)
	{
		// Get the class aliases
		$aliases = Config::get('app.aliases');

		// Figure out what the real model class should be
		$model = $aliases[$related];

		return parent::hasMany($model, $foreignKey);
	}

	/**
	 * Define a many-to-many relationship.
	 *
	 * We override this method from the Eloquent model so that we
	 * can grab the class alias from the config file and create
	 * the model based on what class SHOULD be used instead of
	 * assuming the core should be used.
	 *
	 * @param  string  $related
	 * @param  string  $table
	 * @param  string  $foreignKey
	 * @param  string  $otherKey
	 * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function belongsToMany($related, $table = null, $foreignKey = null, $otherKey = null)
	{
		// Get the class aliases
		$aliases = Config::get('app.aliases');

		// Figure out what the real model class should be
		$model = $aliases[$related];

		return parent::belongsToMany($model, $table, $foreignKey, $otherKey);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Helpers
	|--------------------------------------------------------------------------
	*/

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

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	/**
	 * Scope the query to active items.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeActive($query)
	{
		if (in_array('status', static::$properties))
		{
			$query->where('status', Status::ACTIVE);
		}
	}

	/**
	 * Scope the query to inactive items.
	 *
	 * @param	Builder		The query builder
	 * @return	void
	 */
	public function scopeInactive($query)
	{
		if (in_array('status', static::$properties))
		{
			$query->where('status', Status::INACTIVE);
		}
	}

	/*
	|--------------------------------------------------------------------------
	| CRUD Operations
	|--------------------------------------------------------------------------
	*/

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
	public static function edit($id, array $data, $returnObject = false, $filter = true)
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