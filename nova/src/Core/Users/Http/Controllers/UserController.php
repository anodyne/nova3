<?php namespace Nova\Core\Users\Http\Controllers;

use User,
	Status,
	UserCreator,
	BaseController,
	Mail as Mailer,
	UserRepositoryContract,
	EditUserRequest, CreateUserRequest, RemoveUserRequest;
use Nova\Core\Users\{Events, Mail};
use Illuminate\Http\Request;

class UserController extends BaseController {

	protected $repo;

	public function __construct(UserRepositoryContract $repo)
	{
		parent::__construct();

		$this->isAdmin = true;

		$this->views->put('structure', 'admin');
		$this->views->put('template', 'admin');

		$this->repo = $repo;

		$this->middleware('auth');
	}

	public function all()
	{
		$user = $this->data->user = new User;

		$this->authorize('manage', $user, "You do not have permission to manage users.");

		$this->views->put('page', 'admin/users/all');
		$this->views->put('scripts', ['admin/users/all']);

		$this->data->apiUrl = apiRoute('api.users.index');
	}

	public function create()
	{
		$this->authorize('create', new User, "You do not have permission to create users.");

		$this->views->put('page', 'admin/users/create');
		$this->views->put('scripts', [
			'typeahead.bundle.min',
			'vue/access-picker',
			'admin/users/create'
		]);
		$this->views->put('styles', ['typeahead']);

		$this->data->roles = app('RoleRepository')->all();
		$this->data->permissions = app('PermissionRepository')->all();
	}

	public function store(CreateUserRequest $request, UserCreator $userCreator)
	{
		// Make sure the user is allowed to take this action
		$this->authorize('create', new User, "You do not have permission to create users.");

		// Create the new user
		$user = $userCreator->create(array_merge($request->all(), ['status' => Status::ACTIVE]));

		// Set the flash content
		if ($user->trashed())
		{
			// Fire the event
			event(new Events\UserRestoredByAdmin($user, $request->get('password')));

			flash()->success("User Restored!", "The account has been restored and the user has been notified and sent their new password.");
		}
		else
		{
			// Fire the event
			event(new Events\UserCreatedByAdmin($user, $request->get('password')));

			flash()->success("User Created!", "The user has been notified of the account creation and sent their password.");
		}

		return redirect()->route('admin.users');
	}

	public function edit($userId)
	{
		$user = $this->data->user = $this->repo->getById($userId);

		$this->authorize('edit', $user, "You do not have permission to edit this user.");

		$this->views->put('page', 'admin/users/create');
		$this->views->put('scripts', [
			'typeahead.bundle.min',
			'vue/access-picker',
			'admin/users/create'
		]);
		$this->views->put('styles', ['typeahead']);

		$this->data->roles = app('RoleRepository')->all();
		$this->data->permissions = app('PermissionRepository')->all();
	}

	public function update(EditUserRequest $request, $userId)
	{
		$user = $this->data->user = $this->repo->getById($userId);

		$this->authorize('edit', $user, "You do not have permission to edit this user.");

		$user = $this->repo->update($user, $request->all());

		if (policy($user)->manage($this->currentUser))
		{
			flash()->success("User Updated!");

			return redirect()->route('admin.users');
		}

		flash()->success("Account Updated!");

		return redirect()->back();
	}

	public function remove($userId)
	{
		$this->isAjax = true;

		$user = $this->repo->getById($userId);

		if ( ! $user)
		{
			$body = alert('danger', "User not found.");
		}
		else
		{
			$body = (policy($user)->remove($this->user, $user))
				? view(locate('page', 'admin/users/remove'), compact('user'))
				: alert('danger', "You do not have permission to remove users.");
		}

		return partial('modal-content', [
			'header' => "Remove User",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveUserRequest $request, $userId)
	{
		$user = $this->repo->getById($userId);

		$this->authorize('remove', $user, "You do not have permission to remove users.");

		$user = $this->repo->delete($user);

		flash()->success("User Removed!");

		return redirect()->route('admin.users');
	}

	public function preferences()
	{
		$this->views->put('page', 'admin/users/preferences');

		$this->data->user = $this->user;

		$this->views->put('scripts', ['admin/users/preferences']);
	}

	public function resetPassword(Request $request)
	{
		$this->isAjax = true;
	}

}
