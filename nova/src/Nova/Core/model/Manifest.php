<?php namespace Nova\Core\Model;

use Model;
use DeptModel;

class Manifest extends Model {

	public $timestamps = false;

	protected $table = 'manifests';
	
	protected static $properties = array(
		'id', 'name', 'order', 'desc', 'header_content', 'status', 'default',
	);

	/**
	 * Has Many: Departments
	 */
	public function departments()
	{
		return $this->hasMany('DeptModel');
	}

}