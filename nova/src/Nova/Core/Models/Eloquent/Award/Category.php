<?php namespace Nova\Core\Models\Eloquent\Award;

use Model;

class Category extends Model {
	
	public $timestamps = false;
	
	protected $table = 'award_categories';

	protected $fillable = array(
		'name', 'desc', 'status',
	);
	
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