<?php namespace Nova\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

class SystemEvent extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'nova.event'; }

}