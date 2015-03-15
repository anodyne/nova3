<?php namespace Nova\Core\Pages\Handlers\Events;

use Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class CachePageRoutes implements ShouldBeQueued {

	use InteractsWithQueue;

	public function __construct(){}

	public function handle($event)
	{
		// Cache the routes in production
		if (app('env') == 'production')
		{
			Artisan::call('route:cache');
		}
	}

}
