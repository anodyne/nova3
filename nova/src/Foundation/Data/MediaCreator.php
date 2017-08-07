<?php namespace Nova\Foundation\Data;

use Nova\Foundation\Media;

class MediaCreator implements Creatable
{
	use BindsData;

	public function create()
	{
		return Media::create($this->data);
	}
}
