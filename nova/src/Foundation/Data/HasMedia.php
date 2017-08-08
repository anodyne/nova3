<?php namespace Nova\Foundation\Data;

use Nova\Foundation\Media;

trait HasMedia
{
	public function getPrimaryMedia()
	{
		$media = $this->media();

		if ($media->count() == 1) {
			return $media->first();
		}

		return $media->where('primary', (int) true)->first();
	}

	public function hasMedia()
	{
		return $this->media()->count() > 0;
	}
	
	public function media()
	{
		return $this->morphMany(Media::class, 'mediable');
	}
}
