<?php namespace Nova\Foundation;

use Eloquent;

class Media extends Eloquent
{
	protected $table = 'media';
	protected $fillable = [
		'mediable_id', 'mediable_type', 'filename', 'mime_type', 'order', 'primary'
	];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function mediable()
	{
		return $this->morphTo();
	}
}
