<?php namespace Nova\Core\Controllers\Admin;

use App;
use Str;
use Event;
use Input;
use Media;
use Status;
use Redirect;
use UserValidator;
use AdminBaseController;
use NovaGeneralException;
use UserRepositoryInterface;
use Symfony\Component\Finder\Finder;

class User extends AdminBaseController {

	public function __construct(UserRepositoryInterface $user)
	{
		parent::__construct();

		// Set the injected interfaces
		$this->user = $user;
	}

	public function getUsers()
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['user.create', 'user.update', 'user.delete'], true);

		// Set the views
		$this->_view = 'admin/user/users';
		$this->_jsView = 'admin/user/users_js';

		// Get all the users
		$this->_data->users = $this->user->active();

		// Get the pending users
		$this->_data->pending = $this->user->pending();

		// Build the delete user modal
		$this->_ajax[] = modal([
			'id'		=> 'deleteUser',
			'header'	=> lang('Short.delete', lang('User'))
		]);
	}
	public function postUsers()
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new UserValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($formAction == 'delete')
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
		if ($this->currentUser->hasAccess('user.create') and $formAction == 'create')
		{
			// Create the user
			$item = $this->user->create(array_merge(Input::all(), ['status' => Status::ACTIVE]));

			// Set the data that'll be used by the email
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

			// Fire the user created event
			Event::fire('nova.user.created', $emailData);

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', lang('user'))
				: lang('Short.alert.failure.create', lang('user'));
		}

		/**
		 * Delete a user.
		 */
		if ($this->currentUser->hasAccess('user.delete') and $formAction == 'delete')
		{
			// Delete the user
			$item = $this->user->delete(Input::get('id'));

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
		// Verify the user is allowed
		$this->currentUser->allowed('user.create', true);

		// Set the views
		$this->_view = 'admin/user/create';

		// Set the user
		$this->_data->user = false;
	}

	public function getEdit($userId)
	{
		// Verify the user is allowed
		$this->currentUser->allowed('user.update', true);

		// Set the views
		$this->_view = 'admin/user/edit';
		$this->_jsView = 'admin/user/edit_js';

		// Set the user
		$user = $this->_data->user = $this->user->find($userId);

		// Get the language directory listing
		$this->_data->languageDir = Finder::create()->directories()->in(APPPATH."lang");

		// Build the delete user modal
		$this->_ajax[] = modal([
			'id'		=> 'deleteAvatar',
			'header'	=> lang('Short.delete', langConcat('User Avatar'))
		]);

		if ( ! $this->currentUser->canEditUser($user))
		{
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized'));
		}
	}
	public function postEdit($userId)
	{
		// Get the action
		$formAction = Input::get('formAction');

		// Set up the validation service
		$validator = new UserValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($formAction == 'delete')
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
		if ($this->currentUser->hasAccess('user.update'))
		{
			// Get the user id
			$userId = (is_numeric(Input::get('id'))) ? Input::get('id') : false;

			// Get the user
			$user = $this->user->find($userId);

			if ($this->currentUser->canEditUser($user))
			{
				if ($formAction == 'basic')
				{
					if (Input::has('password'))
					{
						// Do the update
						$this->user->update(Input::get('id'), Input::all());

						$flashStatus = 'success';
						$flashMessage = lang('Short.alert.success.update', lang('user'));
					}
					else
					{
						// Make sure their current password is right
						if (App::make('sentry.hasher')->hash(Input::get('password')) == $user->password)
						{
							// Make sure the new password matches the confirmation
							if (Input::get('password_new') == Input::get('password_new_confirm'))
							{
								// Do the update
								$this->user->update(Input::get('id'), array_merge(Input::all(), ['password' => Input::get('password_new')]));
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

				if ($formAction == 'bio' or $formAction == 'preferences' or $formAction == 'notifications')
				{
					// Do the update
					switch ($formAction)
					{
						case 'bio':
							$item = $this->user->updateFormData(Input::get('id'), Input::all());

							$text = 'user bio';
						break;

						case 'preferences':
						case 'notifications':
							$item = $this->user->updatePreferences(Input::get('id'), Input::all());

							if ($formAction == 'preferences')
								$text = 'user preferences';

							if ($formAction == 'notifications')
								$text = 'user notification preferences';
						break;
					}

					// Set the flash info
					$flashStatus = ($item) ? 'success' : 'danger';
					$flashMessage = ($item) 
						? lang('Short.alert.success.update', langConcat($text))
						: lang('Short.alert.failure.update', langConcat($text));
				}

				if ($formAction == 'admin')
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

		return Redirect::to("admin/user/edit/{$userId}")
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

	public function getLink($userId = false)
	{
		# code...
	}
	public function postLink($userId = false)
	{
		# code...
	}

	public function getUploadUserImage($userId = false)
	{
		// Set the view files
		$this->_view = 'admin/user/upload';
		$this->_jsView = 'admin/user/upload_js';

		$this->_data->id = $this->_jsData->id = $userId;
		$this->_jsData->uploadSize = Media::getFileSizeLimit();
		$this->_jsData->acceptedFiles = Media::getFileFormats('csv');
	}
	public function postUploadUserImage($userId = false)
	{
		// Get the user
		$user = $this->user->find($userId);

		if ($this->currentUser->canEditUser($user))
		{
			// Set the model we're using for uploading
			Media::setModel($user);

			// Get the file we're uploading
			$file = Input::file('file');

			// Set the filename
			$filename = Str::random(32).'.'.$file->getClientOriginalExtension();

			// Upload the file
			$upload = Media::add(
				$filename,
				APPPATH."assets/images/users",
				['mime_type' => $file->getMimeType(), 'uploader' => $this->currentUser->id]
			);
		}
	}

	public function getUserAvatar($userId = false)
	{
		// Upload a 32 pixel version to assets/images/users/sm
		// Upload a 64 pixel version to assets/images/users/sm with @2x

		// Upload a 64 pixel version to assets/images/users/md
		// Upload a 128 pixel version to assets/images/users/md with @2x

		// Upload a 200 pixel version to assets/images/users/lg
		// Upload a 400 pixel version (if possible) to assets/images/users/lg with @2x

		$this->_view = 'admin/user/avatar';
		$this->_jsView = 'admin/user/avatar_js';

		$this->_data->user = $this->user->find($userId);
	}
	public function postUserAvatar()
	{
		# code...
	}
	public function deleteUserAvatar()
	{
		// Get the user
		$user = $this->user->find(Input::get('id'));

		if ($this->currentUser->canEditUser($user))
		{
			// Remove the user avatar
			$media = Media::remove($user->getMedia());

			return Redirect::to("admin/user/edit/{$user->id}")
				->with('flashStatus', 'success')
				->with('flashMessage', lang('Short.alert.success.delete', langConcat('user avatar')));
		}

		return Redirect::to("admin/user/edit/{$user->id}")
			->with('flashStatus', 'danger')
			->with('flashMessage', lang('error.admin.user.notAuthorized'));
	}

}