<?php namespace Nova\Core\Model;

use Model;
use ManifestModel;
use PositionModel;

class Department extends Model {

	protected $table = 'departments_';
	
	protected static $properties = array(
		'id', 'name', 'desc', 'order', 'status', 'type', 'parent_id', 
		'manifest_id',
	);

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

	# TODO: How do we do this the "Laravel way"?
	public static function _init()
	{
		static::$_table_name = static::$_table_name.\Config::get('nova.genre');
	}
	
}