<?php namespace Nova\Core\Model\Application;

use Model;
use NovaApp;
use User;

class Response extends Model {
	
	const COMMENT		= 1; // comment on an application
	const VOTE 			= 2; // vote on an application
	const RESPONSE		= 3; // the response sent to the user
	const EMAIL			= 4; // an email to the applicant

	protected $table = 'application_responses';
	
	protected static $_properties = array(
		'id', 'app_id', 'user_id', 'type', 'content', 'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Application
	 */
	public function app()
	{
		return $this->belongsTo('NovaApp');
	}

	/**
	 * Belongs To: User
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}
	
}