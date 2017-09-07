<?php namespace Nova\Media\Http\Controllers;

use Str;
use Image;
use Storage;
use Controller;
use Nova\Users\User;
use Nova\Media\Media;
use Nova\Characters\Character;

class MediaController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function store()
	{
		switch (request('type')) {
			case 'character':
				$this->authorize('media', Character::find(request('id')));
				break;

			case 'user':
				$this->authorize('media', User::find(request('id')));
				break;
		}

		$location = request('location');
		$imageName = Str::random().'.png';
		$path = storage_path("app/public/{$location}/{$imageName}");

		Storage::makeDirectory("public/{$location}");

		$image = Image::make(file_get_contents(request('image')))->save($path);

		$data = array_merge(request()->all(), [
			'filename' => $imageName,
			'mime' => $image->mime(),
		]);

		$media = creator(Media::class)->with($data)->create();

		return response($media, 200);
	}

	public function update(Media $media)
	{
		$this->authorize('media', $media->mediable);

		$media->makePrimary();

		return response($media->fresh(), 200);
	}

	public function destroy(Media $media)
	{
		$this->authorize('media', $media->mediable);

		deletor(Media::class)->delete($media);

		return response($media, 200);
	}

	public function reorder()
	{
		collect(request('media'))->each(function ($id, $index) {
			Media::find($id)->reorder($index);
		});

		return response(200);
	}
}
