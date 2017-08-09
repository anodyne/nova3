<?php namespace Nova\Foundation\Http\Controllers;

use Str;
use Image;
use Storage;
use Nova\Foundation\Media;

class MediaController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function store()
	{
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
		//
	}

	public function destroy(Media $media)
	{
		# code...
	}

	public function reorder()
	{
		collect(request('media'))->each(function ($id, $index) {
			Media::find($id)->reorder($index);
		});

		return response(200);
	}
}
