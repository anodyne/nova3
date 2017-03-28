<?php namespace Nova\Foundation\Services;

use Illuminate\Support\Facades\Facade;

class FlashNotifierFacade extends Facade
{
	/**
	* Get the registered name of the component.
	*
	* @return string
	*/
	protected static function getFacadeAccessor()
	{
		return 'nova.flash';
	}
}
