<?php namespace Nova\Foundation\Data;

use Nova\Foundation\Media;

class MediaCreator implements Creatable
{
	use BindsData;

	public function create()
	{
		$media = Media::create([
			'mediable_id' => $this->data['id'],
			'mediable_type' => $this->data['type'],
			'filename' => $this->data['filename'],
			'mime_type' => $this->data['mime'],
		]);

		$updateData = [
			'order' => $media->mediable->media->count()
		];

		if ($updateData['order'] == 1) {
			$updateData['primary'] = (int) true;
		}

		$media->update($updateData);

		return $media;
	}
}
