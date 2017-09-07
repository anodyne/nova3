<?php namespace Nova\Foundation\Data;

use Storage;
use Nova\Foundation\Data\BindsData;

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

		// If the image we're deleting is the primary, we've got some work to do...
		if ($media->primary === (int) true) {
			// Make sure we have all the media, but exclude the image we're deleting
			$allMedia = $media->mediable->media->filter(function ($m) use ($media) {
				return $m->id != $media->id;
			});

			// As long as there's something left, set the first one as the primary
			if ($allMedia->count() > 0) {
				$allMedia->first()->update(['primary' => (int) true]);
			}
		}

		// Delete the file
		Storage::disk('public')->delete($path);

		// Delete the media record
		$media->delete();

		return $media;
	}
}
