<?php namespace Nova\Core\Lib;

use Sentry;
use Utility;
use SystemEventModel;

class SystemEvent {

	/**
	 * Add a new system event.
	 *
	 * @param	dynamic		The content to pass to the lang() function
	 * @return	void
	 */
	public static function addSystemEvent()
	{
		static::add('system', func_get_args());
	}

	/**
	 * Add a new user event.
	 *
	 * @param	dynamic		The content to pass to the lang() function
	 * @return	void
	 */
	public static function addUserEvent()
	{
		static::add('user', func_get_args());
	}

	/**
	 * Use the SystemEventModel to add the event.
	 *
	 * @internal
	 * @param	string	The type of event
	 * @param	array	The arguments to pass to the lang() function
	 * @return	void
	 */
	protected static function add()
	{
		// Get the arguments
		$args = func_get_args();

		// Set the type
		$type = $args[0];

		// Remove type from the array
		unset($args[0]);

		// Reset the arguments array indices
		$args = array_values($args[1]);

		// Get the current user
		$user = Sentry::getUser();

		SystemEventModel::add(array(
			'email'			=> ($user !== null) ? $user->email : '',
			'ip'			=> Utility::realIp(),
			'user_id'		=> ($user !== null and $type == 'user') ? $user->id : 0,
			'content'		=> call_user_func_array('lang', $args),
		));
	}

	public static function cleanup()
	{
		# code...
	}

}