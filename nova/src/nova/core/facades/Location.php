<?php namespace nova\core\facades;

use Illuminate\Support\Facades\Facade;

class Location extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'nova.location'; }

}