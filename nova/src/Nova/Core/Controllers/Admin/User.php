<?php namespace Nova\Core\Controllers\Admin;

use Str;
use Event;
use Image;
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
		$this->view = 'admin/user/users';
		$this->jsView = 'admin/user/users_js';

		// Get all the users
		$this->data->users = $this->user->active();

		// Get the pending users
		$this->data->pending = $this->user->pending();

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

		/**
		 * Update a user.
		 */
		if ($this->currentUser->hasAccess('user.update'))
		{
			if ($formAction == 'deactivate')
			{
				//
			}

			if ($formAction == 'activate')
			{
				//
			}
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
		$this->view = 'admin/user/create';

		// Set the user
		$this->data->user = false;
	}

	public function getEdit($userId)
	{
		// Verify the user is allowed
		$this->currentUser->allowed('user.update', true);

		// Set the views
		$this->view = 'admin/user/edit';
		$this->jsView = 'admin/user/edit_js';

		// Set the user
		$user = $this->data->user = $this->user->find($userId);

		// Get the language directory listing
		$this->data->languageDir = Finder::create()->directories()->in(APPPATH."lang");

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
				# FIXME: issues with password fields being empty

				if ($formAction == 'basic')
				{
					if ( ! Input::has('password'))
					{
						// Do the update
						$this->user->update(Input::get('id'), Input::all());

						$flashStatus = 'success';
						$flashMessage = lang('Short.alert.success.update', lang('user'));
					}
					else
					{
						// Make sure their current password is right
						if ($this->app->make('sentry.hasher')->hash(Input::get('password')) == $user->password)
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
					// Moderation

					// Change access level

					// Is system admin

					// Is game master
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
		// Verify the user is allowed
		$this->currentUser->allowed('user.update', true);

		// Set the view files
		$this->view = 'admin/user/upload';
		$this->jsView = 'admin/user/upload_js';

		// Get the user
		$user = $this->user->find($userId);

		// Set the data
		$this->data->id = $this->jsData->id = $userId;
		$this->jsData->uploadSize = Media::getFileSizeLimit();
		$this->jsData->acceptedFiles = Media::getFileFormats('csv');

		if ( ! $this->currentUser->canEditUser($user))
		{
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized'));
		}
	}
	public function postUploadUserImage($userId = false)
	{
		// Get the user
		$user = $this->user->find($userId);

		if ( ! $this->currentUser->canEditUser($user))
		{
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized'));
		}
		else
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
		// Verify the user is allowed
		$this->currentUser->allowed('user.update', true);

		// Set the views
		$this->view = 'admin/user/avatar';
		$this->jsView = 'admin/user/avatar_js';

		// Get the user
		$user = $this->data->user = $this->user->find($userId);

		if ( ! $this->currentUser->canEditUser($user))
		{
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized'));
		}
	}
	public function postUserAvatar($userId = false)
	{
		// Get the user
		$user = $this->user->find($userId);

		if ( ! $this->currentUser->canEditUser($user))
		{
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized'));
		}
		else
		{
			// Get the file info and break it apart
			$fileInfo = explode('.', $user->getMedia()->filename);
			$filename = $fileInfo[0];
			$extension = '.'.$fileInfo[1];

			// Create a new image object
			$image = new Image(APPPATH."assets/images/users/{$filename}{$extension}", Input::all());

			$image->crop(32, 32, APPPATH.'assets/images/users/sm/'.$filename.$extension);
			$image->crop(64, 64, APPPATH.'assets/images/users/sm/'.$filename.'@2x'.$extension);
			$image->crop(64, 64, APPPATH.'assets/images/users/md/'.$filename.$extension);
			$image->crop(128, 128, APPPATH.'assets/images/users/md/'.$filename.'@2x'.$extension);
			$image->crop(200, 200, APPPATH.'assets/images/users/lg/'.$filename.$extension);

			// Only create a large avatar if the crop is big enough
			if ((int) Input::get('height') >= 400)
				$image->crop(400, 400, APPPATH.'assets/images/users/lg/'.$filename.'@2x'.$extension);

			return Redirect::to("admin/user/edit/{$user->id}")
				->with('flashStatus', 'succcess')
				->with('flashMessage', lang('Short.alert.success.update', langConcat('user avatar')));
		}
	}
	public function deleteUserAvatar()
	{
		// Get the user
		$user = $this->user->find(Input::get('id'));

		if ( ! $this->currentUser->canEditUser($user))
		{
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized'));
		}
		else
		{
			// Remove the user avatar
			$media = Media::remove($user->getMedia());

			return Redirect::to("admin/user/edit/{$user->id}")
				->with('flashStatus', 'success')
				->with('flashMessage', lang('Short.alert.success.delete', langConcat('user avatar')));
		}
	}

}