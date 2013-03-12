<?php namespace Nova\Core\Model;

use Model;
use AwardCategory;

class Award extends Model {

	protected $table = 'awards';
	
	protected static $properties = array(
		'id', 'name', 'image', 'category_id', 'order', 'desc', 'type', 'status',
	);

	/**
	 * Belongs To: Award Category
	 */
	public function category()
	{
		return $this->belongsTo('AwardCategory');
	}

}