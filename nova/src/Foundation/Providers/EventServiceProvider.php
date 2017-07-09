<?php namespace Nova\Foundation\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [];

	/**
	 * Register any events for your application.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->listen = config('maps.events');

		parent::boot();
	}
}
