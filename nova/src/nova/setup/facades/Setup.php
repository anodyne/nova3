<?php namespace Nova\Setup\Facades;

use Illuminate\Support\Facades\Facade;

class Setup extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'nova.setup'; }

}