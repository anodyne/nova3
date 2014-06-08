<?php namespace Nova\Core\Traits;

use Session;

trait UtilityTrait {

	/**
	 * Add the flash status and message to the session flash.
	 *
	 * @param	string	$status		The flash status
	 * @param	string	$message	The flash message
	 * @return	void
	 */
	public function setFlashMessage($status, $message)
	{
		Session::flash('flashStatus', $status);
		Session::flash('flashMessage', $message);
	}

}