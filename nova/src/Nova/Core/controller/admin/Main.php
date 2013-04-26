<?php namespace Nova\Core\Controller\Admin;

use Sentry;
use AdminBaseController;

class Main extends AdminBaseController {

	/**
	 * Error Codes
	 */
	const OK 				= 0;
	const NOT_ALLOWED 		= 1;

	public function getIndex()
	{
		$this->_view = 'admin/main/index';

		$this->_data->header = 'Control Panel';
		$this->_data->message = false;

		s(Sentry::check());
		//s($_COOKIE);
	}

	public function getError()
	{
		// Get the error code
		$code = $this->request->segment(4);

		// Set the data
		switch ($code)
		{
			case self::NOT_ALLOWED:
				$this->_data->header = "Not Allowed";
				$this->_data->message = "You don't have permission to view that page.";
			break;
		}
	}

}