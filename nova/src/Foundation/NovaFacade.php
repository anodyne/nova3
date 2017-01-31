<?php namespace Nova\Foundation;

use Illuminate\Support\Facades\Facade;

class NovaFacade extends Facade {

	/**
	* Get the registered name of the component.
	*
	* @return string
	*/
	protected static function getFacadeAccessor() { return 'nova'; }
}
