<?php namespace Nova\Core\Model;

use Model;
 
class Settings extends Model {

	public $timestamps = false;
	
	protected $table = 'settings';
	
	protected static $properties = array(
		'id', 'key', 'value', 'label', 'help', 'user_created',
	);
	
	/**
	 * Get a specific set of settings from the database.
	 *
	 * @param	mixed 	A string with one key, an array of keys to use or false for all settings
	 * @param	bool	Whether to pull the value only (applies to single key requests only)
	 * @return	mixed
	 */
	public static function getItems($keys = false, $valueOnly = true)
	{
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

}