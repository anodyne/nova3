<?php namespace Nova\Core\Models\Eloquent;

use Model;

class Manifest extends Model {

	public $timestamps = false;

	protected $table = 'manifests';

	protected $fillable = array(
		'name', 'order', 'desc', 'header_content', 'status', 'default',
	);
	
	protected static $properties = array(
		'id', 'name', 'order', 'desc', 'header_content', 'status', 'default',
	);

	/**
	 * Has Many: Departments
	 */
	public function departments()
	{
		return $this->hasMany('Dept');
	}

}