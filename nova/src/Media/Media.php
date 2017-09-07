<?php namespace Nova\Media;

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

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function makePrimary()
	{
		// Reset everything to not be primary
		$this->mediable->media->each(function ($m) {
			updater(Media::class)->with(['primary' => (int) false])->update($m);
		});

		// Now set this one as the primary
		$this->update(['primary' => (int) true]);

		return $this;
	}
}
