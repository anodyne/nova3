<?php namespace Nova\Auth\Http\Controllers;

use Nova\Foundation\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
	use AuthenticatesUsers;

	protected $redirectTo = '/home';

	public function __construct()
	{
		parent::__construct();
		
		$this->redirectTo = route('home');

		$this->middleware('guest')->except('logout');
	}

	public function showLoginForm()
	{
		return view('pages.auth.login');
	}

	protected function authenticated(Request $request, $user)
	{
		//
	}
}
