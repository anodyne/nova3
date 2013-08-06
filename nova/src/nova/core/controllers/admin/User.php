<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Sentry;
use Location;
use Redirect;
use AdminBaseController;

class User extends AdminBaseController {

	public function getAll()
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['user.create', 'user.update', 'user.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/user/users_js';

		// Set the view
		$this->_view = 'admin/user/users';

		// Get all the users
		$this->_data->users = \User::active()->get();

		// Build the delete user modal
		$this->_ajax[] = View::make(Location::partial('common/modal'))
			->with('modalId', 'deleteUser')
			->with('modalHeader', lang('Short.delete', lang('User')))
			->with('modalBody', '')
			->with('modalFooter', false);
	}

	public function getEdit($id)
	{
		# code...
	}
	public function postEdit($id)
	{
		# code...
	}

	public function getLoa()
	{
		# code...
	}
	public function postLoa()
	{
		# code...
	}

}