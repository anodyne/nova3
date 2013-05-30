<?php namespace Nova\Core\Models\Entities;

use Model;
use Status;

class Form extends Model {

	protected $table = 'forms';

	protected $fillable = array(
		'key', 'name', 'orientation', 'status',
	);

	protected $dates = array('created_at', 'updated_at');
	
	protected static $properties = array(
		'id', 'key', 'name', 'orientation', 'status', 'created_at', 'updated_at',
	);

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
	
	/**
	 * Has Many: Tabs
	 */
	public function tabs()
	{
		return $this->hasMany('NovaFormTab', 'form_id');
	}

	/**
	 * Has Many: Sections
	 */
	public function sections()
	{
		return $this->hasMany('NovaFormSection', 'form_id');
	}

	/**
	 * Has Many: Fields
	 */
	public function fields()
	{
		return $this->hasMany('NovaFormField', 'form_id');
	}

	/**
	 * Get a form by key.
	 *
	 * @param	string	The form key
	 * @return	Form
	 */
	public static function getForm($key)
	{
		// Start a new Query Builder
		$query = static::startQuery();

		return $query->where('key', $key)->first();
	}

	/**
	 * Get all forms.
	 *
	 * @param	int		The status to pull
	 * @param	bool	Get the full object (true) or a simple array (false)
	 * @return	Collection|array
	 */
	public static function getForms($status = Status::ACTIVE, $returnObj = false)
	{
		// Start a new query builder
		$query = static::startQuery();

		if ( ! empty($status))
		{
			$query->where('status', $status);
		}

		// Get everything
		$items = $query->get();

		if ($returnObj)
		{
			return $items;
		}

		return $items->toSimpleArray('key', 'name');
	}

}