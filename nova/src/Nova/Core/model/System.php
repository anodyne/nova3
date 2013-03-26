<?php namespace Nova\Core\Model;

use Model;

class System extends Model {

	protected $table = 'system_info';

	protected $fillable = array(
		'uid', 'version_major', 'version_minor', 'version_update',
		'version_ignore',
	);
	
	protected static $properties = array(
		'id', 'uid', 'version_major', 'version_minor', 'version_update', 
		'version_ignore', 'created_at', 'updated_at',
	);
	
	/**
	 * Get the RPG unique identifier.
	 *
	 * @return	string
	 */
	public static function getUniqueId()
	{
		// Start a new Query Builder
		$query = static::startQuery();

		return $query->find(1)->uid;
	}
	
	/**
	 * Update the system information.
	 *
	 * @param	array	The content to use in the update
	 * @return	System
	 */
	public static function updateInfo(array $data)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		// Get the first record in the table
		$record = $query->find(1);
		
		// Loop through the data we have and update the object
		foreach ($data as $key => $value)
		{
			$record->{$key} = $value;
		}
		
		// Save the record
		$record->save();
		
		return $record;
	}

}