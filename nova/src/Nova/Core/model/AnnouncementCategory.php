<?php namespace Nova\Core\Model;

use Model;
use Status;
use AnnouncementModel;

class AnnouncementCategory extends Model {

	public $timestamps = false;
	
	protected $table = 'announcement_categories';
	
	protected static $properties = array(
		'id', 'name', 'status',
	);

	/**
	 * Has Many: Announcements
	 */
	public function announcements()
	{
		return $this->hasMany('AnnouncementModel');
	}

}