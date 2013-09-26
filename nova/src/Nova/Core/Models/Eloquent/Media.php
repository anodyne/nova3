<?php namespace Nova\Core\Models\Eloquent;

use HTML;
use Model;

class Media extends Model {

	protected $table = 'media';

	protected $fillable = [
		'imageable_type', 'imageable_id', 'filename', 'mime_type', 'resource_type',
		'user_id', 'ip_address',
	];

	protected $dates = ['created_at', 'updated_at'];
	
	protected static $properties = [
		'id', 'imageable_type', 'imageable_id', 'filename', 'mime_type', 
		'resource_type', 'user_id', 'ip_address', 'created_at', 'updated_at',
	];

	/**
	 * Polymorphic Relationship
	 */
	public function imageable()
	{
		return $this->morphTo();
	}

	public function getRelativePath($type)
	{
		return "app/assets/images/{$type}/{$this->filename}";
	}

	public function getAbsolutePath($type)
	{
		return APPPATH."assets/images/{$type}/{$this->filename}";
	}

	public function getImageTag($type)
	{
		return HTML::image($this->getRelativePath($type));
	}

}