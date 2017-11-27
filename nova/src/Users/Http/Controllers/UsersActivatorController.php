<?php namespace Nova\Users\Http\Controllers;

use Controller;
use Nova\Users\User;

class UsersActivatorController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function update(User $user)
	{
		$this->authorize('update', $user);

		updater(User::class)->activate($user);

		return response($user, 200);
	}

	public function destroy(User $user)
	{
		$this->authorize('update', $user);

		updater(User::class)->deactivate($user);

		return response($user, 200);
	}
}
