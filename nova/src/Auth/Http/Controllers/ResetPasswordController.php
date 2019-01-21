<?php

namespace Nova\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Auth\Http\Responses\ResetPasswordResponse;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return app(ResetPasswordResponse::class)
            ->withToken($token)
            ->withEmail($request->email);
    }

    public function redirectTo()
    {
        return route('home');
    }
}
