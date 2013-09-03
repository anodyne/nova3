<?php namespace Nova\Core\Controllers\Admin;

use App;
use View;
use Input;
use Notify;
use Sentry;
use Status;
use Location;
use Redirect;
use DynamicForm;
use UserValidator;
use AdminBaseController;
use Symfony\Component\Finder\Finder;

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
		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

		// Set up the validation service
		$validator = new UserValidator;

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

		/**
		 * Create a user.
		 */
		if ($user->hasAccess('user.create') and $action == 'create')
		{
			// Create the user
			$item = \User::create(array_merge(Input::all(), ['status' => Status::ACTIVE]));

			// Set the content keys
			$contentKeys = [
				'content' => 'email.content.user_create'
			];

			// Set the data being passed to the email
			$emailData = [
				'to'		=> $item->email,
				'content'	=> lang('email.content.user.create', 
								lang('user'),
								$this->settings->sim_name,
								$this->request->root(),
								Input::get('name'),
								Input::get('password')),
				'subject'	=> lang('email.subject.user.create'),
			];

			// Send the notification
			Notify::send('basic', $emailData, $contentKeys);

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
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
			$item = \User::find($id);

			// Delete the user
			$remove = $item->deleteUser();

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
		// Set the views
		$this->_view = 'admin/user/edit';

		// Set the user
		$this->_data->user = \User::find($id);

		// Build the user form
		$this->_data->userForm = DynamicForm::setup('user', $id, true)->build();

		// Get the language directory listing
		$this->_data->languageDir = Finder::create()->directories()->in(APPPATH."lang");
	}
	public function postEdit($id)
	{
		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

		// Set up the validation service
		$validator = new UserValidator;

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

		/**
		 * Update the user.
		 */
		if ($user->hasAccess('user.update'))
		{
			// Get the user id
			$userId = (is_numeric(Input::get('id'))) ? e(Input::get('id')) : false;

			// Get the user
			$item = \User::find($userId);

			if (($user->hasLevel('user.update', 1) and $item == $user) or $user->hasLevel('user.update', 2))
			{
				if ($action == 'basic')
				{
					if (Input::has('password'))
					{
						// Do the update
						$item->update(Input::all());

						$flashStatus = 'success';
						$flashMessage = lang('Short.alert.success.update', lang('user'));
					}
					else
					{
						// Make sure their current password is right
						if (App::make('sentry.hasher')->hash(Input::get('password')) == $item->password)
						{
							// Make sure the new password matches the confirmation
							if (Input::get('password_new') == Input::get('password_new_confirm'))
							{
								// Do the update
								$item->update(array_merge(Input::all(), ['password' => e(Input::get('password_new'))]));
							}
							else
							{
								$flashStatus = 'danger';
								$flashMessage = lang('error.admin.user.passwordsNotMatching');
							}
						}
						else
						{
							$flashStatus = 'danger';
							$flashMessage = lang('error.admin.user.wrongPassword');
						}
					}
				}

				if ($action == 'bio')
				{
					//
				}

				if ($action == 'preferences')
				{
					//
				}

				if ($action == 'notifications')
				{
					//
				}

				if ($action == 'admin')
				{
					//
				}
			}
			else
			{
				$flashStatus = 'danger';
				$flashMessage = lang('error.admin.user.notAuthorized');
			}
		}

		return Redirect::to("admin/user/edit/{$id}")
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
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