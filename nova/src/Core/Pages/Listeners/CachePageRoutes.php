<?php namespace Nova\Core\Pages\Listeners;

use Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CachePageRoutes implements ShouldQueue {

	use InteractsWithQueue;

	public function __construct(){}

	public function handle($event)
	{
		// Cache the routes only if we're in production
		if (app('env') == 'production')
		{
			Artisan::call('route:cache');
		}
	}

}
