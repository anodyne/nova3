<?php namespace Nova\Core\Model;

use Model;
use DepartmentModel;

class Manifest extends Model {

	protected $table = 'manifests';
	
	protected static $_properties = array(
		'id', 'name', 'order', 'desc', 'header_content', 'status', 'default',
	);

	/**
	 * Has Many: Departments
	 */
	public function departments()
	{
		return $this->hasMany('DepartmentModel');
	}

}