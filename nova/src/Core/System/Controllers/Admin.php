<?php namespace Nova\Core\Controllers\Admin;

use ErrorCode;
use AdminBaseController;

class Admin extends AdminBaseController {

	public function getIndex()
	{
		$this->view = 'admin/admin/index';

		$this->data->header = 'Control Panel';
		$this->data->message = false;
	}

	public function getError($code)
	{
		switch ($code)
		{
			case ErrorCode::ADMIN_NOT_ALLOWED:
				$this->data->header = "Not Allowed";
				$this->data->message = "You don't have permission to view that page.";
			break;
		}
	}

}