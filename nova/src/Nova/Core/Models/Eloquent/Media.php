<?php namespace Nova\Core\Models\Eloquent;

use URL;
use File;
use Model;

class Media extends Model {

	protected $table = 'media';

	protected $fillable = [
		'type', 'entry_id', 'filename', 'mime_type', 'user_id', 'ip_address',
	];

	protected $dates = ['created_at', 'updated_at'];
	
	protected static $properties = [
		'id', 'type', 'entry_id', 'filename', 'mime_type', 'user_id', 'ip_address', 
		'created_at', 'updated_at',
	];

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	/**
	 * Scope the query to a media entry.
	 *
	 * @param	Builder		The query builder
	 * @param	int			Entry ID
	 * @return	void
	 */
	public function scopeEntry($query, $id)
	{
		$query->where('entry_id', $id);
	}

	/**
	 * Scope the query to a type of media.
	 *
	 * @param	Builder		The query builder
	 * @param	string		Type
	 * @return	void
	 */
	public function scopeType($query, $type)
	{
		$query->where('type', $type);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Get the relative path to the image.
	 *
	 * @param	string	$type	The type of image
	 * @param	string	$size	The size of the image (not always applicable)
	 * @return	string
	 */
	public function getAbsolutePath($type, $size = false)
	{
		if ( ! $size)
			if (File::exists(APPPATH."assets/images/{$type}/{$this->filename}"))
				return APPPATH."assets/images/{$type}/{$this->filename}";
			else
				return NOVAPATH."assets/img/avatar-sm.png";

		if (File::exists(APPPATH."assets/images/{$type}/{$size}/{$this->filename}"))
			return APPPATH."assets/images/{$type}/{$size}/{$this->filename}";
		else
			return NOVAPATH."assets/img/avatar-{$size}.png";
	}

	/**
	 * Get the path to the image with the full URL.
	 *
	 * @param	string	$type	The type of image
	 * @param	string	$size	The size of the image
	 * @return	string
	 */
	public function getPathWithUrl($type, $size = false)
	{
		if ( ! $size)
			return URL::to("/app/assets/images/{$type}/{$this->filename}");

		return URL::to("/app/assets/images/{$type}/{$size}/{$this->filename}");
	}

	/**
	 * Get the relative path to the image.
	 *
	 * @param	string	$type	The type of image
	 * @param	string	$size	The size of the image (not always applicable)
	 * @return	string
	 */
	public function getRelativePath($type, $size = false)
	{
		if ( ! $size)
			return "app/assets/images/{$type}/{$this->filename}";

		return "app/assets/images/{$type}/{$size}/{$this->filename}";
	}

}