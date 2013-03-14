<?php namespace Nova\Core\Model\Application;

use Model;

class Rule extends Model {
	
	public $timestamps = false;

	protected $table = 'application_rules';
	
	protected static $properties = array(
		'id', 'type', 'condition', 'users',
	);

}