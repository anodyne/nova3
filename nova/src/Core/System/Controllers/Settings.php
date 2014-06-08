<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Location;
use Redirect;
use AdminBaseController;

class Settings extends AdminBaseController {

	public function getBasic()
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['settings.create', 'settings.update', 'settings.delete'], true);

		// Set the view
		$this->view = 'admin/settings/basic';

		// Send the settings to the view
		$this->data->settings = \SettingsModel::basicSettings()->get();
	}

	public function getAdvanced()
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['settings.create', 'settings.update', 'settings.delete'], true);

		// Set the view
		$this->view = 'admin/settings/advanced';

		// Send the settings to the view
		$this->data->settings = \SettingsModel::basicSettings()->get();
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