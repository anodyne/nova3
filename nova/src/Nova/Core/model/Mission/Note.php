<?php namespace Nova\Core\Model\Mission;

use Model;
use Mission;

class Note extends Model {

	protected $table = 'mission_notes';
	
	protected static $properties = array(
		'id', 'mission_id', 'content', 'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Mission
	 */
	public function mission()
	{
		return $this->belongsTo('Mission');
	}

}