<?php namespace Nova\Foundation\Data;

use Storage;

class MediaDeletor implements Deletable
{
	use BindsData;

	public function delete($media)
	{
		// Figure out the path to the image
		$path = join(DIRECTORY_SEPARATOR, [
			str_plural($media->mediable_type),
			$media->filename
		]);

		// Delete the file
		Storage::disk('public')->delete($path);

		// Delete the media record
		$media->delete();

		return $media;
	}
}
