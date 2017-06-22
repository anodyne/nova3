<?php namespace Nova\Users\Http\Controllers;

use Nova\Users\User;
use Nova\Foundation\Http\Controllers\Controller;

class UsersController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function index()
	{
		$userClass = new User;

		$this->authorize('manage', $userClass);

		$users = User::get();

		return view('pages.users.all-users', compact('users', 'userClass'));
	}
}
