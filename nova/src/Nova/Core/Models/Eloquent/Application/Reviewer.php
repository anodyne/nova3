<?php namespace Nova\Core\Models\Eloquent\Application;

use Model;

class Reviewer extends Model {
	
	public $timestamps = false;

	protected $table = 'application_reviewers';

	protected $fillable = array(
		'app_id', 'user_id',
	);
	
	protected static $properties = array(
		'id', 'app_id', 'user_id',
	);

	/**
	 * Belongs To: Application
	 */
	public function app()
	{
		return $this->belongsTo('ApplicationModel');
	}

}