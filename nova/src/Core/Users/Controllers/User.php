<?php namespace Nova\Core\Controllers\Admin;

use Str,
	Event,
	Image,
	Input,
	Media,
	Status,
	Redirect,
	UserValidator,
	AdminBaseController,
	NovaGeneralException,
	UserRepositoryInterface;
use Symfony\Component\Finder\Finder;

class User extends AdminBaseController {

	protected $user;

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
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		if ($this->currentUser->hasAccess('user.create'))
		{
			// Set up the input array
			$input = Input::all() + ['status' => Status::ACTIVE];
			
			// Create the user
			$user = $this->user->create($input);

			// Fire the user created event
			Event::fire('nova.user.created', [$user, $input]);

			return Redirect::to('admin/user');
		}
		else
		{
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.create')));
		}
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
		
		if ($this->currentUser->canEditUser($user))
		{
			// Set the model we're using for uploading
			Media::setModel($user);

			// Add the media
			Media::add(APPPATH."assets/images/users", ['uploader' => $this->currentUser->id]);
		}
		else
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.update')));
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

		if ($this->currentUser->canEditUser($user))
		{
			Media::cropSquare($user->getMedia(), APPPATH."assets/images/users/", Input::all(), [
				['size' => 32, 'dir' => 'sm', 'retina' => false],
				['size' => 64, 'dir' => 'sm', 'retina' => true],
				['size' => 64, 'dir' => 'md', 'retina' => false],
				['size' => 128, 'dir' => 'md', 'retina' => true],
				['size' => 200, 'dir' => 'lg', 'retina' => false],
				['size' => 400, 'dir' => 'lg', 'retina' => true],
			]);

			return Redirect::to("admin/user/edit/{$user->id}")
				->with('flashStatus', 'success')
				->with('flashMessage', lang('Short.alert.success.update', langConcat('user avatar')));
		}
		else
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.update')));
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
		else
			throw new NovaGeneralException(lang('error.admin.user.notAuthorized', lang('action.update')));
	}

}