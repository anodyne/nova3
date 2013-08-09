<?php namespace Nova\Core\Controllers\Admin;

use View;
use Input;
use Sentry;
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

		// Build the delete user modal
		$this->_ajax[] = View::make(Location::partial('common/modal'))
			->with('modalId', 'deleteUser')
			->with('modalHeader', lang('Short.delete', lang('User')))
			->with('modalBody', '')
			->with('modalFooter', false);

		// Build the link character modal
		$this->_ajax[] = View::make(Location::partial('common/modal'))
			->with('modalId', 'linkUser')
			->with('modalHeader', lang('short.admin.users.link', lang('Character'), lang('User')))
			->with('modalBody', '')
			->with('modalFooter', false);
	}
	public function postAll()
	{
		// Set up the validation service
		$validator = new UserValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			// Set the flash message
			$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
			$flashMessage.= implode(' ', $validator->getErrors()->all());

			return Redirect::to('admin/user')
				->with('flashStatus', 'danger')
				->with('flashMessage', $flashMessage);
		}

		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

		/**
		 * Create a user.
		 */
		if ($user->hasAccess('user.create') and $action == 'create')
		{
			// Create the user
			$user = \User::create(Input::all());

			// Set the flash info
			$flashStatus = ($user) ? 'success' : 'danger';
			$flashMessage = ($user) 
				? lang('Short.alert.success.create', lang('user'))
				: lang('Short.alert.failure.create', lang('user'));
		}

		/**
		 * Link a character to a user.
		 */
		if ($user->hasAccess('user.update') and $action == 'link')
		{
			// Get the user ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			if ($id)
			{
				// Get the character ID
				$characterId = e(Input::get('character_id'));
				$characterId = (is_numeric($characterId)) ? $characterId : false;
				
				// Update the user
				$user = \User::find($id);
				$user->update(['character_id' => $characterId]);
			}

			// Set the flash info
			$flashStatus = ($id) ? 'success' : 'danger';
			$flashMessage = ($id) 
				? lang('Short.alert.success.update', lang('user'))
				: lang('Short.alert.failure.update', lang('user'));
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

			if ($user->canBeDeleted())
			{
				// Delete all characters associated with the user
				foreach ($user->characters as $character)
				{
					$character->delete();
				}

				// Delete the user
				$user->delete();

				// Set the flash info
				$flashStatus = 'success';
				$flashMessage = lang('Short.alert.success.delete', lang('user'));
			}
			else
			{
				// User cannot be deleted
				$flashStatus = 'danger';
				$flashMessage = lang('error.admin.cannotBeDeleted', lang('user'));
			}
		}

		return Redirect::to('admin/user')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

	public function getCreate()
	{
		# code...
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