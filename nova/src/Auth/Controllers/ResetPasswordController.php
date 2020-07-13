<?php

namespace Nova\Auth\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Auth\Responses\ResetPasswordResponse;
use Illuminate\Foundation\Auth\ResetsPasswords;

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
        return app(ResetPasswordResponse::class)->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function redirectTo()
    {
        return route('home');
    }
}
