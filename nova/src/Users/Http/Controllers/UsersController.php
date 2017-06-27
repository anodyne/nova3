<?php namespace Nova\Users\Http\Controllers;

use Nova\Users\User;
use Nova\Authorize\Role;
use Nova\Users\UserCreator;
use Illuminate\Http\Request;
use Nova\Users\UserRepository;
use Nova\Foundation\Http\Controllers\Controller;

class UsersController extends Controller
{
	protected $usersRepo;

	public function __construct(UserRepository $usersRepo)
	{
		parent::__construct();

		$this->middleware('auth');

		$this->usersRepo = $usersRepo;
	}

	public function index()
	{
		$userClass = new User;

		$this->authorize('manage', $userClass);

		$users = $this->usersRepo->all([], true);

		return view('pages.users.all-users', compact('users', 'userClass'));
	}

	public function create()
	{
		$this->authorize('create', new User);

		$roles = Role::with('permissions')->get();

		return view('pages.users.create-user', compact('roles'));
	}

	public function store(Request $request)
	{
		$this->authorize('create', new User);

		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users'
		], [
			'name.required' => _m('user-validation-name'),
			'email.required' => _m('user-validation-email-required'),
			'email.email' => _m('user-validation-email-email'),
			'email.unique' => _m('user-validation-email-unique')
		]);

		$this->usersRepo->create($request->all());

		flash()->success(
			_m('user-flash-added-title'),
			_m('user-flash-added-message')
		);

		return redirect()->route('users.index');
	}

	public function edit(User $user)
	{
		$this->authorize('update', $user);

		$roles = Role::get();

		return view('pages.users.update-user', compact('user', 'roles'));
	}

	public function update(Request $request, User $user)
	{
		$this->authorize('update', $user);

		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users'
		], [
			'name.required' => _m('user-validation-name'),
			'email.required' => _m('user-validation-email-required'),
			'email.email' => _m('user-validation-email-email'),
			'email.unique' => _m('user-validation-email-unique')
		]);

		$this->usersRepo->update($user, $request->all());

		flash()->success(
			_m('user-flash-updated-title'),
			_m('user-flash-updated-message')
		);

		return redirect()->route('users.index');
	}

	public function destroy(User $user)
	{
		$this->authorize('delete', $user);

		$this->usersRepo->delete($user);

		flash()->success(
			_m('user-flash-deleted-title'),
			_m('user-flash-deleted-message')
		);

		return redirect()->route('users.index');
	}

	public function restore(User $user)
	{
		$this->authorize('update', $user);

		$this->usersRepo->restore($user);

		flash()->success(
			_m('user-flash-restored-title'),
			_m('user-flash-restored-message')
		);

		return redirect()->route('users.index');
	}
}
