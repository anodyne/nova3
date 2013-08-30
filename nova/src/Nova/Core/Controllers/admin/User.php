<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Sentry;
use Status;
use Location;
use Redirect;
use UserValidator;
use AdminBaseController;

class User extends AdminBaseController {

	public function getAll()
	{
		// Verify the user is allowed
		Sentry::getUser()->allowed(['user.create', 'user.update', 'user.delete'], true);

		// Set the views
		$this->_view = 'admin/user/users';
		$this->_jsView = 'admin/user/users_js';

		// Get all the users
		$this->_data->users = \User::active()->get();

		// Get the pending users
		$this->_data->pending = \User::pending()->get();

		// Build the delete user modal
		$this->_ajax[] = View::make(Location::partial('common/modal'))
			->with('modalId', 'deleteUser')
			->with('modalHeader', lang('Short.delete', lang('User')))
			->with('modalBody', '')
			->with('modalFooter', false);
	}
	public function postAll()
	{
		// Set up the validation service
		$validator = new UserValidator;

		// Get the action
		$action = e(Input::get('action'));

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($action == 'delete')
			{
				// Set the flash message
				$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
				$flashMessage.= implode(' ', $validator->getErrors()->all());

				return Redirect::to('admin/user')
					->with('flashStatus', 'danger')
					->with('flashMessage', $flashMessage);
			}

			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		// Get the current user
		$user = Sentry::getUser();

		/**
		 * Create a user.
		 */
		if ($user->hasAccess('user.create') and $action == 'create')
		{
			// Create the user
			$user = \User::create(array_merge(Input::all(), ['status' => Status::ACTIVE]));

			// Set the flash info
			$flashStatus = ($user) ? 'success' : 'danger';
			$flashMessage = ($user) 
				? lang('Short.alert.success.create', lang('user'))
				: lang('Short.alert.failure.create', lang('user'));
		}

		/**
		 * Delete a user.
		 */
		if ($user->hasAccess('user.delete') and $action == 'delete')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the user
			$user = \User::find($id);

			// Delete the user
			$remove = $user->deleteUser();

			// Set the flash info
			$flashStatus = ($remove) ? 'success' : 'danger';
			$flashMessage = ($remove) 
				? lang('Short.alert.success.delete', lang('user'))
				: lang('Short.alert.failure.delete', lang('user'));
		}

		return Redirect::to('admin/user')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

	public function getCreate()
	{
		// Set the views
		$this->_view = 'admin/user/create';

		// Set the user
		$this->_data->user = false;
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

	public function getLink($id = false)
	{
		# code...
	}
	public function postLink()
	{
		# code...
	}

}