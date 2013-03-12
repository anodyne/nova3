<?php namespace Nova\Core\Model;

use Model;

class Form extends Model {

	protected $table = 'forms';
	
	protected static $properties = array(
		'id', 'key', 'name', 'orientation',
	);

	/**
	 * Get a form by key.
	 *
	 * @param	string	The form key
	 * @return	Form
	 */
	public static function getForm($key)
	{
		// Get a new instance of the model
		$instance = new static;

		// Start a new Query Builder
		$query = $instance->newQuery();

		return $query->where('key', $key)->first();
	}

	/**
	 * Get all forms.
	 *
	 * @return	array
	 */
	public static function getForms()
	{
		$items = static::find('all');

		$records = array();

		if (count($items) > 0)
		{
			foreach ($items as $item)
			{
				$records[$item->key] = $item->name;
			}
		}

		return $records;
	}

}