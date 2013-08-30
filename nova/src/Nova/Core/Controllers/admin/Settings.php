<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Sentry;
use Location;
use Redirect;
use AdminBaseController;

class Settings extends AdminBaseController {

	public function getBasic()
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['settings.create', 'settings.update', 'settings.delete'], true);

		// Set the view
		$this->_view = 'admin/settings/basic';

		// Send the settings to the view
		$this->_data->settings = \Settings::basicSettings()->get();
	}

	public function getAdvanced()
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['settings.create', 'settings.update', 'settings.delete'], true);

		// Set the view
		$this->_view = 'admin/settings/advanced';

		// Send the settings to the view
		$this->_data->settings = \Settings::basicSettings()->get();
	}

	public function getCreate()
	{
		// Create a new setting item
	}

	public function postSettings($type)
	{
		# code...
	}

}