<?php namespace Nova\Core\Model;

use Model;

class Media extends Model {

	protected $table = 'media';

	protected $fillable = array(
		'filename', 'mime_type', 'resource_type', 'user_id', 'ip_address',
	);
	
	protected static $properties = array(
		'id', 'imageable_type', 'imageable_id', 'filename', 'mime_type', 
		'resource_type', 'user_id', 'ip_address', 'created_at', 'updated_at',
	);

	/**
	 * Polymorphic Relationship
	 */
	public function imageable()
	{
		return $this->morphTo();
	}

}