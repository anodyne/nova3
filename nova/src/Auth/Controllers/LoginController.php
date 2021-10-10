<?php

declare(strict_types=1);

namespace Nova\Auth\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Nova\Auth\Responses\LoginResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest')->except('logout');
    }

    public function redirectTo(): string
    {
        return route('dashboard');
    }

    public function showLoginForm(): Responsable
    {
        return app(LoginResponse::class);
    }
}
