<?php namespace Nova\Core\Model;

use Model;
use Config;
use ManifestModel;
use PositionModel;

class Department extends Model {

	protected $table = 'departments_';
	
	protected static $properties = array(
		'id', 'name', 'desc', 'order', 'status', 'type', 'parent_id', 
		'manifest_id', 'created_at', 'updated_at',
	);

	/**
	 * Since the table name is appended with the genre, we can't hard-code
	 * it in to the model. When the object is created, we have to pull the
	 * genre out of the config and name the table.
	 *
	 * @internal
	 * @return	void
	 */
	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);

		// Set the name of the table
		$this->setTable('departments_'.Config::get('nova.genre'));
	}

	/**
	 * Belongs To: Manifest
	 */
	public function manifest()
	{
		return $this->belongsTo('ManifestModel');
	}

	/**
	 * Has Many: Positions
	 */
	public function positions()
	{
		return $this->hasMany('PositionModel');
	}
	
}