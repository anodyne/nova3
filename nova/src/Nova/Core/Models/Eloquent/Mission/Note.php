<?php namespace Nova\Core\Models\Eloquent\Mission;

use Model;

class Note extends Model {

	protected $table = 'mission_notes';

	protected $fillable = array(
		'mission_id', 'content',
	);

	protected $dates = array('created_at', 'updated_at');
	
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