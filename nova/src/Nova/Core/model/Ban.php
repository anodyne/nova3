<?php namespace Nova\Core\Model;

use Model;

class Ban extends Model {

	protected $table = 'bans';
	
	protected static $properties = array(
		'id', 'level', 'ip_address', 'email', 'reason', 'created_at', 'updated_at'
	);

	/**
	 * Get bans.
	 *
	 * @param	string	The value to use
	 * @param	string	The column to use
	 * @return	Collection
	 */
	public static function getItems($value, $column = 'email')
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		return $query->where($column, $value)->get();
	}

}