<?php namespace Nova\Core\Handler;

use Log;
use PostModel;

class Post {

	public function created($model)
	{
		Log::info('Post created. Handler used.');
	}

	public function updated($model)
	{
		Log::info('Post updated. Handler used.');
	}
	
}