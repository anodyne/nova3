<?php namespace Nova\Core\Controllers\Admin;

use ErrorCode;
use AdminBaseController;

class Admin extends AdminBaseController {

	public function getIndex()
	{
		$this->_view = 'admin/admin/index';

		$this->_data->header = 'Control Panel';
		$this->_data->message = false;
	}

	public function getError($code)
	{
		// Set the data
		switch ($code)
		{
			case ErrorCode::ADMIN_NOT_ALLOWED:
				$this->_data->header = "Not Allowed";
				$this->_data->message = "You don't have permission to view that page.";
			break;
		}
	}

}