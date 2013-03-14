<?php namespace Nova\Core\Model;

use Model;
use PostModel;
use MediaModel;
use MissionNoteModel;
use MissionGroupModel;

class Mission extends Model {

	protected $table = 'missions';
	
	protected static $properties = array(
		'id', 'title', 'images', 'order', 'group_id', 'status', 'start_date', 
		'end_date', 'desc', 'summary', 'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Mission Group
	 */
	public function group()
	{
		return $this->belongsTo('MissionGroupModel');
	}

	/**
	 * Has Many: Mission Notes
	 */
	public function notes()
	{
		return $this->hasMany('MissionNoteModel');
	}

	/**
	 * Has Many: Mission Posts
	 */
	public function posts()
	{
		return $this->hasMany('PostModel');
	}

	/**
	 * Polymorphic Relationship: Media
	 */
	public function images()
	{
		return $this->morphMany('MediaModel', 'imageable');
	}

}