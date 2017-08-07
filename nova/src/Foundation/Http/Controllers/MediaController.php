<?php namespace Nova\Foundation\Http\Controllers;

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
		dd(request(), request()->all(), request()->file());
		// Put the image where it belongs
		request()->file('file')->store(request('type'));

		// Create the media object
		$media = creator(Media::class)->with(request()->all())->create();

		return response($media, 200);
	}

	public function destroy(Media $media)
	{
		# code...
	}
}
