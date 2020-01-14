<?php

namespace Nova\Auth\Http\Controllers;

use Nova\Auth\Http\Responses\LoginResponse;
use Nova\Foundation\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return app(LoginResponse::class);
    }

    public function redirectTo()
    {
        return route('dashboard');
    }
}
