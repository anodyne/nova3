<?php namespace Nova\Core\Models\Entities;

use Cache;
use Event;
use Model;
use Config;
use stdClass;
use CacheInterface;
 
class Settings extends Model implements CacheInterface {

	public $timestamps = false;
	
	protected $table = 'settings';

	protected $fillable = array(
		'key', 'value', 'label', 'help',
	);
	
	protected static $properties = array(
		'id', 'key', 'value', 'label', 'help', 'user_created',
	);

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Boot the model and define the event listeners.
	 *
	 * @return	void
	 */
	public static function boot()
	{
		parent::boot();

		// Get all the aliases
		$classes = Config::get('app.aliases');

		Event::listen("eloquent.created: {$classes['Settings']}", "{$classes['SettingsHandler']}@afterCreate");
		Event::listen("eloquent.updated: {$classes['Settings']}", "{$classes['SettingsHandler']}@afterUpdate");
		Event::listen("eloquent.deleting: {$classes['Settings']}", "{$classes['SettingsHandler']}@beforeDelete");
		Event::listen("eloquent.saved: {$classes['Settings']}", "{$classes['SettingsHandler']}@afterSave");
	}
	
	/**
	 * Get a specific set of settings from the database.
	 *
	 * @param	mixed 	A string with one key, an array of keys to use or false for all settings
	 * @param	bool	Whether to pull the value only (applies to single key requests only)
	 * @return	mixed
	 */
	public static function getSettings($keys = false, $valueOnly = true)
	{
		// Check the cache
		$items = Cache::get('nova.settings');

		// If we have the cache, use it
		if (($items !== null and $items !== false) and $valueOnly)
		{
			if (is_array($keys))
			{
				// Create an object to return
				$retval = new stdClass;

				// Loop through the keys and add them to the object
				foreach ($keys as $k)
				{
					$retval->{$k} = $items->{$k};
				}

				return $retval;
			}

			return $items->{$keys};
		}

		// Start a new Query Builder
		$query = static::startQuery();

		if (is_array($keys))
		{
			return $query->whereIn('key', $keys)->get()->toSimpleObject('key', 'value');
		}
		else
		{
			if ( ! $keys)
			{
				return $query->get()->toSimpleObject('key', 'value');
			}
			else
			{
				$result = $query->where('key', $keys)->first();
				
				if ($valueOnly)
				{
					return $result->value;
				}
				
				return $result;
			}
		}
	}
	
	/**
	 * Update system settings.
	 *
	 * You can also pass a larger array with multiple values to the method to
	 * update multiple settings at the same time. The data array just needs to
	 * stay in the (setting key) => (setting value) format.
	 *
	 * @param	array 	The data for updating the settings
	 * @return	void
	 */
	public static function updateItems(array $data)
	{
		foreach ($data as $key => $value)
		{
			// Start a new query
			$query = static::startQuery();

			$record = $query->where('key', $key)->first();

			if ($record)
			{
				$record->value = $value;
				$record->save();
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	| CacheInterface Implementation
	|--------------------------------------------------------------------------
	*/

	public static function cache($name = 'nova.settings', $length = false)
	{
		// Start by flushing the cache
		static::clearCache($name);

		// Start a new query
		$query = static::startQuery();

		if ($length === false)
		{
			Cache::forever($name, $query->get()->toSimpleObject('key', 'value'));
		}
		else
		{
			Cache::put($name, $query->get()->toSimpleObject('key', 'value'), $length);
		}
	}

	public static function clearCache($name = 'nova.settings')
	{
		Cache::forget($name);
	}

}