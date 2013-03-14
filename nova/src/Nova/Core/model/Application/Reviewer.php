<?php namespace Nova\Core\Model\Application;

use Model;
use AppModel;

class Reviewer extends Model {
	
	public $timestamps = false;

	protected $table = 'application_reviewers';
	
	protected static $properties = array(
		'id', 'app_id', 'user_id',
	);

	/**
	 * Belongs To: Application
	 */
	public function app()
	{
		return $this->belongsTo('AppModel');
	}

}