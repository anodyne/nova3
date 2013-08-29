<?php namespace nova\core\lib;

use Sentry;
use Request;
use SystemEventModel;

class SystemEvent {

	/**
	 * Add a new system event.
	 *
	 * @param	dynamic		The content to pass to the lang() function
	 * @return	void
	 */
	public function addSystemEvent()
	{
		$this->add('system', func_get_args());
	}

	/**
	 * Add a new user event.
	 *
	 * @param	dynamic		The content to pass to the lang() function
	 * @return	void
	 */
	public function addUserEvent()
	{
		$this->add('user', func_get_args());
	}

	/**
	 * Use the SystemEventModel to add the event.
	 *
	 * @internal
	 * @param	string	Type of event
	 * @param	array	Arguments to pass to the lang() function
	 * @return	void
	 */
	protected function add()
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

		SystemEventModel::create([
			'email'		=> ($user !== null and $type == 'user') ? $user->email : '',
			'ip'		=> Request::getClientIp(),
			'user_id'	=> ($user !== null and $type == 'user') ? $user->id : 0,
			'content'	=> call_user_func_array('lang', $args),
		]);
	}

	public function cleanup()
	{
		# code...
	}

}