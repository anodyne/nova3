<?php

namespace Nova\Auth\Http\Controllers;

use Nova\Auth\Http\Responses\SignInResponse;
use Nova\Foundation\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
		parent::__construct();

		$this->middleware('guest')->except('logout');

		$this->renderWithTheme = false;
	}

	public function showLoginForm()
    {
		$this->renderWithTheme = true;

		return app(SignInResponse::class);
	}

	public function redirectTo()
    {
        return route('dashboard');
    }
}