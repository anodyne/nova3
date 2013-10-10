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
	}
	public function postUsers()
	{
		// Set up the validation service
		$validator = new UserValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
			return Redirect::back()->withInput()->withErrors($validator->getErrors());

		if ($this->currentUser->hasAccess('user.update'))
		{
			if (Input::get('formAction') == 'deactivate')
			{
				//
			}

			if (Input::get('formAction') == 'activate')
			{
				//
			}
		}

		return Redirect::to('admin/user')
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}
	public function deleteUsers()
	{
		if ($this->currentUser->hasAccess('user.delete'))
		{
			// Delete the user
			$user = $this->user->delete(Input::get('id'));

			// Fire the user deleted event
			Event::fire('nova.user.deleted', $user);
		}

		else
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.delete')));

		return Redirect::to('admin/user');
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
	public function postCreate()
	{
		// Set up the validation service
		$validator = new UserValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
			return Redirect::back()->withInput()->withErrors($validator->getErrors());

		if ($this->currentUser->hasAccess('user.create'))
		{
			// Create the user
			$user = $this->user->create(array_merge(Input::all(), ['status' => Status::ACTIVE]));

			// Fire the user created event
			Event::fire('nova.user.created', $user, Input::all());
		}

		else
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.create')));

		return Redirect::to('admin/user');
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

		if ( ! $this->currentUser->canEditUser($user))
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized'));
	}
	public function postEdit($userId)
	{
		// Set up the validation service
		$validator = new UserValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
			return Redirect::back()->withInput()->withErrors($validator->getErrors());

		/**
		 * Update the user.
		 */
		if ($this->currentUser->hasAccess('user.update'))
		{
			// Get the user
			$user = $this->user->find($userId);

			if ( ! $this->currentUser->canEditUser($user))
				throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.update')));

			// Do the update
			$this->user->update(Input::get('id'), Input::all());

			// Fire the user updated event
			Event::fire('nova.user.updated', $user, Input::all());
		}

		else
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.update')));

		return Redirect::to("admin/user/edit/{$userId}");
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
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.update')));
	}
	public function postUploadUserImage($userId = false)
	{
		// Get the user
		$user = $this->user->find($userId);

		if ( ! $this->currentUser->canEditUser($user))
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.update')));
		
		else
		{
			// Set the model we're using for uploading
			Media::setModel($user);

			// Get the file we're uploading
			$file = Input::file('file');

			// Set the filename
			$filename = Str::random(32).'.'.$file->getClientOriginalExtension();

			// Upload the file
			$upload = Media::add($filename, APPPATH."assets/images/users", [
				'mime_type'	=> $file->getMimeType(),
				'uploader'	=> $this->currentUser->id
			]);

			# FIXME: the controller shouldn't know about the details of uploading
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
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.update')));
	}
	public function postUserAvatar($userId = false)
	{
		// Get the user
		$user = $this->user->find($userId);

		if ( ! $this->currentUser->canEditUser($user))
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.update')));
		
		else
		{
			Media::cropSquare($user->getMedia(), APPPATH."assets/images/users/", Input::all(), [
				['size' => 32, 'path' => 'sm', 'retina' => false],
				['size' => 64, 'path' => 'sm', 'retina' => true],
				['size' => 64, 'path' => 'md', 'retina' => false],
				['size' => 128, 'path' => 'md', 'retina' => true],
				['size' => 200, 'path' => 'lg', 'retina' => false],
				['size' => 400, 'path' => 'lg', 'retina' => true],
			]);

			# FIXME: the controller shouldn't know the details about cropping

			/*// Get the file info and break it apart
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
				$image->crop(400, 400, APPPATH.'assets/images/users/lg/'.$filename.'@2x'.$extension);*/

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
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.update')));
		
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