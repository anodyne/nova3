<?php namespace Nova\Core\Model\Mission;

use Model;
use Mission;
use MissionGroup;

class Group extends Model {

	protected $table = 'mission_groups';
	
	protected static $properties = array(
		'id', 'name', 'order', 'desc', 'parent_id', 'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Mission Group
	 */
	public function group()
	{
		return $this->belongsTo('MissionGroup', 'parent_id');
	}

	/**
	 * Has Many: Mission Notes
	 */
	public function missions()
	{
		return $this->hasMany('Mission');
	}

}