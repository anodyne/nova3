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
	 * @return	Ban
	 * @todo	Should this be removed in favor of something else?
	 */
	public static function getItems($value, $column = 'email')
	{
		return static::query()->where($column, $value)->get();
	}

}