<?php namespace Nova\Foundation;

use Eloquent;
use Nova\Foundation\Data\Reorderable;

class Media extends Eloquent
{
	use Reorderable;

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
