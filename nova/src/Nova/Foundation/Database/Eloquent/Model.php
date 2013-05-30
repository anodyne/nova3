<?php namespace Nova\Foundation\Database\Eloquent;

/**
 * The model class is the foundation for all of Nova's models and provides core
 * functionality that's shared across many of the models used in Nova. Because
 * these methods are available in every model, any changes to this class should
 * be done carefully and  deliberately since they can cause wide ranging issues
 * if not done properly.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

use Date;
use Config;
use Status;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {
	
	/*
	|--------------------------------------------------------------------------
	| Eloquent Model Method Overrides
	|--------------------------------------------------------------------------
	*/

	protected $dates = [];

	public function __construct(array $attributes = [])
	{
		$attributes = $this->scrubInputData($attributes);

		parent::__construct($attributes);
	}

	/**
	 * Create a new Eloquent Collection instance.
	 *
	 * We override this method from the Eloquent model so that we can ensure
	 * every collection being created is one of our own making and not the
	 * default.
	 *
	 * @param	array	An array of models
	 * @return	Collection
	 */
	public function newCollection(array $models = [])
	{
		return new Collection($models);
	}

	/**
	 * Get the attributes that should be converted to dates.
	 *
	 * @return array
	 */
	public function getDates()
	{
		return $this->dates;
	}

	/**
	 * Get a fresh timestamp for the model.
	 *
	 * We override this method from the Eloquent model so that we can ensure
	 * that every timestamp being generated is done so as UTC.
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
	 * We override this method from the Eloquent model so that we can ensure
	 * that everything being stored in the database is being done so as UTC.
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
	 * We override this method from the Eloquent model so that we can grab the
	 * class alias from the config file and create the model based on what class
	 * SHOULD be used instead of assuming the core should be used.
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
	 * We override this method from the Eloquent model so that we can grab the
	 * class alias from the config file and create the model based on what class
	 * SHOULD be used instead of assuming the core should be used.
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
	 * We override this method from the Eloquent model so that we can grab the
	 * class alias from the config file and create the model based on what class
	 * SHOULD be used instead of assuming the core should be used.
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
	 * We override this method from the Eloquent model so that we can grab the
	 * class alias from the config file and create the model based on what class
	 * SHOULD be used instead of assuming the core should be used.
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
	 * Scrub the data being used to make sure we're can store it in the table.
	 *
	 * @param	array	Array of data to scrub
	 * @return	array
	 */
	protected function scrubInputData(array $data)
	{
		// Loop through the data and scrub it for any issues
		foreach ($data as $key => $value)
		{
			// Make sure we're only using fillable fields
			if ( ! $this->isFillable($key))
			{
				unset($data[$key]);
			}
		}

		return $data;
	}

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	/**
	 * Active items scope.
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
	 * Inactive items scope.
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

	/**
	 * Ascending order scope.
	 *
	 * @param	Builder		The query builder
	 * @param	string		The field to order by
	 * @return	void
	 */
	public function scopeOrderAsc($query, $orderBy)
	{
		$this->orderScope($query, $orderBy, 'asc');
	}

	/**
	 * Descending order scope.
	 *
	 * @param	Builder		The query builder
	 * @param	string		The field to order by
	 * @return	void
	 */
	public function scopeOrderDesc($query, $orderBy)
	{
		$this->orderScope($query, $orderBy, 'desc');
	}

	/**
	 * Do the ordering.
	 *
	 * @param	Builder		Query Builder object
	 * @param	mixed		A string or array of strings of columns
	 * @param	string		The direction to order
	 * @return	void
	 */
	protected function orderScope($query, $column, $direction)
	{
		if (is_array($column))
		{
			foreach ($column as $col)
			{
				if (in_array($col, static::$properties))
				{
					$query->orderBy($col, $direction);
				}
			}
		}
		else
		{
			if (in_array($column, static::$properties))
			{
				$query->orderBy($column, $direction);
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Static methods
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

	/**
	 * Find a record/records in the table based on the simple arguments.
	 *
	 * @param	mixed	The column or arguments for a where statement
	 * @param	string	The value
	 * @return	Collection
	 */
	public static function getItems($column, $value)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		if (is_array($column))
		{
			// Loop through the arguments and build the where clause
			foreach ($column as $col => $val)
			{
				if (in_array($col, static::$properties))
				{
					$query->where($col, $val);
				}
			}
			
			return $query->get();
		}
		else
		{
			if (in_array($column, static::$properties))
			{
				return $query->where($column, $value)->get();
			}
		}
		
		return false;
	}

	/**
	 * Find a form item based on the form key.
	 *
	 * @param	string	Form key
	 * @param	bool	Get only active items?
	 * @return	Collection
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

}