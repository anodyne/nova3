<?php namespace Nova\Core\Model\Award;

use Model;
use Award;

class Category extends Model {
	
	public $timestamps = false;
	
	protected $table = 'award_categories';
	
	protected static $properties = array(
		'id', 'name', 'desc', 'status',
	);

	/**
	 * Has Many: Awards
	 */
	public function awards()
	{
		return $this->hasMany('Award');
	}

}