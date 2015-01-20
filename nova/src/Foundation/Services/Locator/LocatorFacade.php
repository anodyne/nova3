<?php namespace Nova\Foundation\Services\Locator;

use Illuminate\Support\Facades\Facade;

class LocatorFacade extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'nova.locator'; }

}