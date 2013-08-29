<?php namespace nova\core\facades;

use Illuminate\Support\Facades\Facade;

class Markdown extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'markdown'; }

}